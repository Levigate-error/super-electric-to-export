import * as React from 'react';
import { reducer } from './reducer';
import { IProjectSpec } from './types';
import TabLinks from '../../ui/TabLinks';
import Specification from './components/Specification';
import { getSpecification, addSection, deleteSection, downloadSpec, updateProjectInfo } from './api';
import { clearIcon } from '../../ui/Icons/Icons';
import UploadModal from '../../components/UploadSpec';
import PageLayout from '../../components/PageLayout';
import Input from '../../ui/Input';
import { Icon, Affix, notification, Tooltip } from 'antd';
import Modal from '../../ui/Modal';

const links = [
    {
        url: '/project/update',
        title: 'Общая информация',
        selected: false,
    },
    {
        url: '/project/products',
        title: 'Добавленная продукция',
        selected: false,
    },
    {
        url: '/project/specifications',
        title: 'Спецификация',
        selected: true,
    },
];

const downloadIconStyle = {
    verticalAlign: 'baseline',
    fontSize: '16px',
    marginRight: 10,
};

function ProjectSpec({ store }: IProjectSpec) {
    const [
        {
            isLoading,
            sectionName,
            specSections,
            leftAffix,
            uploadModalIsOpen,
            downloadModalIsOpen,
            downloadLink,
            specPrepare,
            totalPrice,
        },
        dispatch,
    ] = React.useReducer(reducer, {
        uploadModalIsOpen: false,
        specSections: [],
        sectionName: '',
        isLoading: false,
        leftAffix: true,
        downloadModalIsOpen: false,
        downloadLink: '',
        specPrepare: false,
        totalPrice: store.project.total_price,
    });

    React.useEffect(() => {
        window.addEventListener('resize', resizeWindow);
        checkAffix(window.innerWidth);
        dispatch({ type: 'fetch' });

        updateSpec();

        return () => {
            window.removeEventListener('resize', resizeWindow);
        };
    }, []);

    const checkAffix = width => {
        if (width > 767) {
            dispatch({ type: 'enable-left-affix' });
        } else {
            dispatch({ type: 'disable-left-affix' });
        }
    };

    const resizeWindow = e => {
        checkAffix(e.target.innerWidth);
    };

    const openNotificationWithIcon = (type, message, description) => {
        notification[type]({
            message,
            description,
        });
    };

    const updateSpec = () => {
        const {
            specification: { id },
        } = store;
        dispatch({ type: 'fetch' });
        getSpecification(id)
            .then(response => {
                setSections(response.data);
                updateProjectInfo(store.project.id)
                    .then(resp => {
                        dispatch({
                            type: 'set-project-price',
                            payload: resp.data.total_price,
                        });
                    })
                    .catch(err => {
                        openNotificationWithIcon('error', 'Ошибка получения информации о проекте', '');
                    });
            })
            .catch(err => {
                openNotificationWithIcon('error', 'Ошибка получения спецификации', '');
            });
    };

    const setSections = (data: any[]) => {
        dispatch({
            type: 'set-spec-sections',
            payload: data,
        });
    };

    const handleDeleteSection = section => {
        const {
            specification: { id },
        } = store;
        deleteSection(id, section.id).then(response => {
            updateSpec();
            setSections(response.data);
        });
    };

    const handleAddSection = () => {
        dispatch({ type: 'fetch' });
        const {
            specification: { id },
        } = store;
        addSection(sectionName, id).then(response => {
            dispatch({ type: 'set-section-name', payload: '' });
            updateSpec();
        });
    };

    const handleChangeSectionName = e =>
        dispatch({
            type: 'set-section-name',
            payload: e.target.value,
        });

    const sectionsMenu = (
        <React.Fragment>
            <ul className="project-spec-list">
                {specSections.map(el => (
                    <li key={el.id || 'fake_section'} className={'project-spec-list-li'}>
                        <span className={'project-spec-list-name'}>
                            <a href={`#section-${el.id}`} className="spec-list-name-link">
                                {el.title}
                            </a>
                            {!el.fake_section && (
                                <span className="spec-list-icon" onClick={() => handleDeleteSection(el)}>
                                    {clearIcon}
                                </span>
                            )}
                        </span>
                    </li>
                ))}
            </ul>
            <div className="proj-spec-add-wrapper">
                <Input
                    onChange={handleChangeSectionName}
                    icon={<Icon type="plus" />}
                    placeholder="Добавить раздел"
                    iconAction={handleAddSection}
                    value={sectionName}
                />
            </div>
        </React.Fragment>
    );

    const handleOpenUploadModal = () => dispatch({ type: 'open-upload-modal' });
    const handleCloseUploadModal = () => dispatch({ type: 'close-upload-modal' });

    const handleDownloadSpec = () => {
        dispatch({ type: 'spec-prepare-to-download' });
        downloadSpec(store.project.id).then(response => {
            dispatch({
                type: 'open-download-modal',
                payload: response.data.url,
            });
        });
    };

    const handleCloseDownloadModal = () => dispatch({ type: 'close-download-modal' });

    return (
        <div className="container mt-4 mb-3">
            <div className="row ">
                <div className="col-md-10 col-sm-12">
                    <TabLinks id={store.project.id} links={links} />
                </div>
                <div className="col-md-2  col-sm-12 upload-download-spec-controls">
                    {store.user && <UploadModal isOpen={uploadModalIsOpen} onClose={handleCloseUploadModal} />}
                    <Modal isOpen={downloadModalIsOpen} onClose={handleCloseDownloadModal}>
                        <a href={downloadLink} download={`${store.project.title}_spec.xlsx`}>
                            <Icon type="download" style={downloadIconStyle} />
                            Скачать спецификацию
                        </a>
                    </Modal>
                    {store.user && (
                        <Tooltip title="Загрузить спецификацию" placement="bottom">
                            <Icon type="upload" onClick={handleOpenUploadModal} className="icon-control" />
                        </Tooltip>
                    )}

                    {specPrepare ? (
                        <Icon type="loading" className="icon-control" />
                    ) : (
                        <Tooltip title="Скачать спецификацию" placement="bottom">
                            <Icon type="download" onClick={handleDownloadSpec} className="icon-control" />
                        </Tooltip>
                    )}
                </div>
            </div>

            <div className="row mt-3">
                <div className="col-md-3">
                    {leftAffix ? <Affix offsetTop={20} children={sectionsMenu} /> : sectionsMenu}
                </div>
                <div className="col-md-9">
                    <Specification
                        isLoading={isLoading}
                        sections={specSections}
                        specification={store.specification}
                        setSections={setSections}
                        projectId={store.project.id}
                        updateSpec={updateSpec}
                    />
                </div>
            </div>
            <div className="row">
                <div className="col-md-3" />
                <div className="col-md-9 spec-total-wrapper ">
                    <span className="spec-total-summ-text">Итого: </span>
                    <span className="spec-total-summ">{totalPrice} ₽</span>
                </div>
            </div>
        </div>
    );
}

export default PageLayout(ProjectSpec);
