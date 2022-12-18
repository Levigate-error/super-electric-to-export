import * as React from 'react';
import Projects from './Projects';
import { createProject } from '../api';
import AuthRegister from '../../AuthRegister';
import { getProjects, addProduct } from '../api';
import { Icon } from 'antd';
import Button from '../../../ui/Button';

interface IAnalog {
    user: any;
    product: any;
}
const Analog = ({ user, product }: IAnalog) => {
    const [authModalIsOpen, setAuthModalIsOpen] = React.useState(false);
    const [isLoading, setIsLoading] = React.useState(false);
    const [projects, setProjects] = React.useState([]);
    const [createIsLoading, setCreateProjectIsLoading] = React.useState(false);
    const [addProductsIsLoading, setAddProductsLoading] = React.useState(false);
    const [addProductError, setAddProductError] = React.useState('');
    const [checkedCount, setCheckedCount] = React.useState(0);

    React.useEffect(() => {
        setIsLoading(true);
        getProjects()
            .then(resp => {
                setIsLoading(false);
                setProjects(resp.data.projects.filter(project => project.status.slug === 'in_work'));
            })
            .catch(error => {
                setIsLoading(false);
            });
    }, []);

    const handleCreateProject = () => {
        setCreateProjectIsLoading(true);
        setAddProductError('');
        const baseUrl = window.location.origin;

        createProject().then(resp => {
            const data = {
                product: product.id,
                projects: [{ amount: 1, project: resp.data.id }],
            };

            addProduct(data)
                .then(response => {
                    document.location.href = baseUrl + '/project/update/' + resp.data.id;
                })
                .catch(err => {
                    setAddProductError('Ошибка добавления продукта');
                });
        });
    };

    const toggleAuthModal = () => setAuthModalIsOpen(!authModalIsOpen);

    const renderProjects = !!projects.length && !isLoading;

    const handleChangeCount = (e, value): void => {
        const targetId = parseInt(e.target.dataset.id);

        const newArr = projects.map(project => {
            if (project.id === targetId) {
                return { ...project, count: value };
            } else {
                return project;
            }
        });

        setProjects(newArr);
    };

    const handleChangeChecked = (value: boolean, id: number): void => {
        const newArray = projects.map(project => {
            if (id === project.id) {
                return { ...project, checked: value };
            } else {
                return project;
            }
        });
        setCheckedCount(newArray.length);
        setProjects(newArray);
    };

    const handleAddProducts = () => {
        setAddProductsLoading(true);
        setAddProductError('');

        const checked = projects.filter(project => project.checked);

        const data = {
            product: product.id,
            projects: checked.map(project => ({ amount: project.count ? project.count : 1, project: project.id })),
        };

        addProduct(data)
            .then(response => {
                document.location.reload();
            })
            .catch(err => {
                setAddProductsLoading(false);
                setAddProductError('Ошибка добавления продукта');
            });
    };

    return (
        <div className="selection-analog-detail-wrapper">
            {authModalIsOpen && <AuthRegister isOpen={authModalIsOpen} onClose={toggleAuthModal} defaultTab={1} />}
            <div className="selection-analog-product">
                <div className="selection-analog-image-wrapper">
                    <img className="selection-analog-image" src={product.img} alt={product.name} title={product.name} />
                </div>
                <div className="selection-analog-info">
                    <div className="selection-analog-info-title">{product.name}</div>
                    <div className="selection-analog-info-description">{product.description}</div>
                    <div className="selection-analog-info-details">
                        <span>
                            <strong>Артикул:</strong> {product.vendor_code}
                        </span>
                        <span>
                            <strong>Цена:</strong> {product.recommended_retail_price} ₽
                        </span>
                    </div>
                </div>
            </div>
            {isLoading && (
                <div className="selection-analog-projects-preloader-wrapper">
                    {' '}
                    <Icon type="loading" className="selection-analog-projects-preloader" />
                </div>
            )}
            {renderProjects && !isLoading && (
                <React.Fragment>
                    <span className="selection-analog-projects-select-text">
                        Выберите проект, в котором требуется добавить аналог
                    </span>
                    <Projects
                        addProducts={handleAddProducts}
                        projects={projects}
                        changeCount={handleChangeCount}
                        chengeChecked={handleChangeChecked}
                        addProductsIsLoading={addProductsIsLoading}
                        checkedCount={checkedCount}
                    />
                </React.Fragment>
            )}
            {!renderProjects && !isLoading && (
                <React.Fragment>
                    <div className="selection-analog-auth-message">
                        {user
                            ? 'У вас нет проектов в работе, создайте проект'
                            : 'У вас нет проектов в работе, создайте проект или авторизуйтесь'}
                    </div>
                    <div className="selection-analog-auth-btns">
                        <Button
                            value="Создать проект"
                            onClick={handleCreateProject}
                            appearance="accent"
                            disabled={createIsLoading}
                            isLoading={createIsLoading}
                        />
                        {!user && (
                            <Button
                                value="Войти"
                                onClick={toggleAuthModal}
                                appearance="second"
                                disabled={createIsLoading}
                            />
                        )}
                    </div>
                </React.Fragment>
            )}
            {!isLoading && !!addProductError && (
                <div className="selection-analog-add-product-error">{addProductError}</div>
            )}
        </div>
    );
};

export default Analog;
