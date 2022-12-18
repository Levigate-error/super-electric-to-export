import * as React from 'react';
import Input from '../Input';
import Button from '../Button';
import { addProductRequest, createProject } from './api';

const createProjectBtn = {
    padding: 0,
    fontSize: 14,
};

interface IAddProduct {
    projects: any[];
    productId: number;
    closeModal: () => void;
    userResource?: any;
}

function reducer(state, { type, payload }: any) {
    switch (type) {
        case 'fetch':
            return { ...state, isLoading: true, errors: [] };
        case 'set-amount':
            return { ...state, productCount: payload };
        case 'add-failure':
            return { ...state, isLoading: false, errors: payload };
        default:
            throw new Error();
    }
}
const AddProduct = ({ projects, productId, closeModal, userResource }: IAddProduct) => {
    const [{ isLoading, productCount, errors }, dispatch] = React.useReducer(reducer, {
        isLoading: false,
        productCount: projects.map(el => ({ ...el, amount: 0 })),
        errors: [],
    });

    const handleChangeAmount = e => {
        const id = parseInt(e.target.dataset.id);
        const value = e.target.value || '0';
        const index = productCount.map(el => el.id).indexOf(id);
        const result: any = Array.from(productCount);
        result[index].amount = parseInt(value, 10);

        dispatch({ type: 'set-amount', payload: result });
    };

    const addProduct = async () => {
        dispatch({ type: 'fetch' });
        const params = {
            product: productId,
            projects: productCount
                .filter(el => el.amount && el.amount > 0)
                .map(el => ({ project: el.id, amount: el.amount })),
        };

        addProductRequest(params).then(response => {
            response.data
                ? closeModal()
                : dispatch({
                      type: 'add-failure',
                      payload: response.errors.projects,
                  });
        });
    };

    const handleCreateProject = () => {
        const base_url = window.location.origin;
        createProject().then(response => {
            document.location.href = base_url + '/project/update/' + response.data.id;
        });
    };

    let lastProjectActivity: any = false;

    if (userResource && !Array.isArray(userResource)) {
        const project = userResource.activities.project;
        if (!Array.isArray(project)) {
            lastProjectActivity = project;
        }
    }

    const lastProject = lastProjectActivity && productCount.find(item => lastProjectActivity.source_id === item.id);
    const projectsInWork = productCount.filter(item => item.status.slug === 'in_work');
    return (
        <div className="add-product-wrapper">
            {projects.length ? (
                <React.Fragment>
                    <h3>Добавление продукта в проект</h3>

                    <ul className="add-product-ul">
                        {lastProjectActivity && lastProject && lastProject.status.slug === 'in_work' && (
                            <li key={lastProjectActivity.source_id} className="add-product-li add-product-last">
                                <span className="project-title">{lastProjectActivity.title}</span>
                                <Input
                                    id={lastProjectActivity.source_id}
                                    value={lastProject.amount || 0}
                                    onChange={handleChangeAmount}
                                    type="number"
                                />
                            </li>
                        )}
                        {productCount.map(item => {
                            return (
                                lastProjectActivity.source_id !== item.id &&
                                item.status.slug === 'in_work' && (
                                    <li key={item.id} className="add-product-li">
                                        <span className="project-title">{item.title}</span>
                                        <Input
                                            id={item.id}
                                            value={`${parseInt(item.amount, 10)}`}
                                            onChange={handleChangeAmount}
                                            type="number"
                                        />
                                    </li>
                                )
                            );
                        })}
                        {!lastProject && projectsInWork.length === 0 && (
                            <li className="add-product-in-work-projects-err">Нет проектов со статусом "В работе".</li>
                        )}
                    </ul>
                    {errors.length > 0 && <span className="add-product-err">Ошибка добавления продукта</span>}

                    {(!!lastProject || projectsInWork.length > 0) && (
                        <Button
                            appearance="accent"
                            onClick={addProduct}
                            value="Добавить продукт"
                            isLoading={isLoading}
                        />
                    )}
                </React.Fragment>
            ) : (
                <React.Fragment>
                    <h5>Еще не создано ни одного проекта</h5>
                    <p>
                        Для добавление продуктов Вам необходимо{' '}
                        <button className="legrand-text-btn" onClick={handleCreateProject} style={createProjectBtn}>
                            создать проект
                        </button>
                        .
                    </p>
                </React.Fragment>
            )}
        </div>
    );
};

export default AddProduct;
