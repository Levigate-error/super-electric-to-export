import * as React from 'react';
import { reducer, initialState, actionTypes } from './reducer';
import Modal from '../../ui/Modal';
import Input from '../../ui/Input';
import Button from '../../ui/Button';
import { getProjects, getAnalogsRequest, addProduct, createProject } from './api';
import { Icon } from 'antd';
import Projects from './elements/Projects';

interface IAnalogSelect {
    isOpen: boolean;
    onClose: () => void;
    user: any;
}

const AnalogsSelect = ({ isOpen, onClose, user }: IAnalogSelect) => {
    const [
        {
            article,
            analog,
            fetchAnalog,
            fetchAnalogError,
            fetchProjects,
            fetchProjectsFailure,
            projects,
            selectedProjects,
            product,
            productAdded,
            addProductFailure,
            addRequest,
        },
        dispatch,
    ] = React.useReducer(reducer, initialState);

    React.useEffect(() => {
        dispatch({ type: actionTypes.FETCH_PROJECTS });

        getProjects()
            .then(resp => {
                dispatch({
                    type: actionTypes.SET_PROJECTS,
                    payload: resp.data.projects,
                });
            })
            .catch(error => {
                dispatch({ type: actionTypes.FETCH_PROJECTS_FAILURE, payload: error });
            });
    }, []);

    const handleChangeArticle = e => dispatch({ type: actionTypes.SET_ARTICLE, payload: e.target.value });

    const handleSearchAnalog = () => {
        dispatch({ type: actionTypes.FETCH_ANALOG });

        getAnalogsRequest(article)
            .then(response => {
                dispatch({ type: actionTypes.SET_ANALOG, payload: response.data[0] });
            })
            .catch(error => {
                dispatch({
                    type: actionTypes.FETCH_ANALOG_FAILURE,
                    payload: 'Аналоги не найдены',
                });
            });
    };

    const handleRefreshAnalog = () => {
        const next = product + 1 === analog.products.length ? 0 : product + 1;

        dispatch({ type: actionTypes.SET_CURRENT_PRODUCT, payload: next });
    };

    const handleChangeCheckbox = (el, value) => {
        const newSelectedProjects = value
            ? [...selectedProjects, el]
            : selectedProjects.filter(proj => proj.id !== el.id);
        dispatch({
            type: actionTypes.SET_SELECTED_PROJECTS,
            payload: newSelectedProjects,
        });
    };

    const handleChangeCount = e => {
        const newValue = parseInt(e.target.value);
        const targetId = parseInt(e.target.dataset.id);
        const newProjects = [...selectedProjects];

        newProjects.forEach(project => {
            if (project.id === targetId) {
                project.count = Math.max(1, newValue || 1);
            }
        });

        dispatch({ type: actionTypes.SET_SELECTED_PROJECTS, payload: newProjects });
    };

    const handleAddToProjects = () => {
        dispatch({ type: actionTypes.ADD_PRODUCT_REQUEST });
        const data = {
            product: analog.products[product].id,
            projects: selectedProjects.map(el => ({
                amount: el.count,
                project: el.id,
            })),
        };

        addProduct(data)
            .then(response => {
                dispatch({ type: actionTypes.ADD_PRODUCT_SUCCESS });
                location.reload();
            })
            .catch(err => {
                dispatch({
                    type: actionTypes.ADD_PRODUCT_FAILURE,
                    payload: 'Ошибка добавления продукта',
                });
                resetAddProductMessages();
            });
    };

    const resetAddProductMessages = () => {
        setTimeout(() => dispatch({ type: actionTypes.RESET_ADD_PRODUCT_ACTION }), 2000);
    };

    const handleCreateProject = () => {
        dispatch({ type: actionTypes.ADD_PRODUCT_REQUEST });
        const base_url = window.location.origin;
        createProject().then(resp => {
            const data = {
                product: analog.products[product].id,
                projects: [{ amount: 1, project: resp.data.id }],
            };

            addProduct(data)
                .then(response => {
                    document.location.href = base_url + '/project/update/' + resp.data.id;
                })
                .catch(err => {
                    dispatch({
                        type: actionTypes.ADD_PRODUCT_FAILURE,
                        payload: 'Ошибка добавления продукта',
                    });
                    resetAddProductMessages();
                });
        });
    };

    return (
        <Modal isOpen={isOpen} onClose={onClose}>
            <div className="get-analog-wrpapper">
                <div className="search-row">
                    <Input value={article} onChange={handleChangeArticle} placeholder="Введите артикул" />
                    <Button onClick={handleSearchAnalog} appearance="accent" value="Подобрать аналог" />
                </div>
                <div className="content-wrapper">
                    <div className="current-product-wrapper">
                        {fetchAnalog && <Icon type="loading" />}
                        {analog ? (
                            <React.Fragment>
                                <h5>{analog.vendor}</h5>
                                <p>{analog.description}</p>
                            </React.Fragment>
                        ) : (
                            <span className="product-error">{fetchAnalogError}</span>
                        )}
                    </div>

                    <div className="refresh-wrapper">
                        {fetchAnalog ? (
                            <Icon type="loading" />
                        ) : (
                            analog && <Icon type="reload" onClick={handleRefreshAnalog} />
                        )}
                    </div>

                    {analog && (
                        <div className="analog-wrapper">
                            <h5 className="analog-name">{analog.products[product].name}</h5>
                            <div className="analog-container">
                                <img
                                    src={analog.products[product].img}
                                    alt={analog.products[product].name}
                                    title={analog.products[product].name}
                                    className="analog-img"
                                />
                                <div className="analog-info">
                                    <span className="analog-description">{analog.products[product].description}</span>
                                    <span className="analog-article">
                                        Артикул: {analog.products[product].vendor_code}
                                    </span>
                                    <span className="analog-cost">
                                        {analog.products[product].recommended_retail_price}₽
                                    </span>
                                </div>
                            </div>
                        </div>
                    )}

                    {fetchAnalogError && (
                        <span className="fetch-analog-failure">
                            Мы не нашли аналог, вы можете подобрать его в каталоге.
                            <br />
                            <a href="/catalog">Перейти в каталог</a>
                        </span>
                    )}

                    {analog &&
                        (fetchProjects ? (
                            <Icon type="loading" />
                        ) : fetchProjectsFailure ? (
                            <span className="projects-fetch-failure">Ошибка загрузки списка проектов</span>
                        ) : (
                            <Projects
                                selectedProjects={selectedProjects}
                                projects={projects}
                                changeCheckbox={handleChangeCheckbox}
                                changeCount={handleChangeCount}
                                addToProjects={handleAddToProjects}
                                createProject={handleCreateProject}
                                addRequest={addRequest}
                                productAdded={productAdded}
                                addProductFailure={addProductFailure}
                                user={user}
                            />
                        ))}
                </div>
            </div>
        </Modal>
    );
};

export default AnalogsSelect;
