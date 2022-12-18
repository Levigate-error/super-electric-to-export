import * as React from 'react';
import { reducer } from './reducer';
import { IProjectProducts } from './types';
import TabLinks from '../../ui/TabLinks';
import AddedProducts from './components/AddedProducts';
import { fetchProductCategories, addCategoryRequest, fetchProjectCategories, deleteCategory } from './api';
import { clearIcon } from '../../ui/Icons/Icons';
import Dropdown from '../../ui/Dropdown';
import PageLayout from '../../components/PageLayout';
import { notification } from 'antd';

const links = [
    {
        url: '/project/update',
        title: 'Общая информация',
        selected: false,
    },
    {
        url: '/project/products',
        title: 'Добавленная продукция',
        selected: true,
    },
    {
        url: '/project/specifications',
        title: 'Спецификация',
        selected: false,
    },
];

function ProjectProducts({ store }: IProjectProducts) {
    const [{ categories, isLoading, projectCategories, selectedCategory }, dispatch] = React.useReducer(reducer, {
        categories: [],
        selectedCategory: false,
        projectCategories: store.projectCategories,
        isLoading: false,
    });

    const categoriesRef = React.useRef<Dropdown>();

    const addedProducts = React.useRef<AddedProducts>();

    React.useEffect(() => {
        dispatch({ type: 'fetch' });
        fetchProductCategories().then(response => {
            if (response.length > 0) {
                projectCategories.length > 0 &&
                    dispatch({
                        type: 'select-category',
                        payload: projectCategories[0],
                    });
            }

            dispatch({ type: 'set-categories', payload: response });
        });
    }, []);

    const addCategory = React.useCallback(
        async item => {
            setTimeout(function() {
                categoriesRef.current.resetDropdown();
            }, 0);
            dispatch({ type: 'fetch' });
            await addCategoryRequest({
                projectId: store.project.id,
                product_category: item.id,
            });
            const newProjectCategories = await fetchProjectCategories(store.project.id);
            dispatch({ type: 'add-category', payload: newProjectCategories });
            dispatch({ type: 'select-category', payload: item });
            addedProducts.current && addedProducts.current.fetchDivisions(item);
        },
        [projectCategories, isLoading, selectedCategory],
    );

    const openNotificationWithIcon = (type, message, description) => {
        notification[type]({
            message,
            description,
        });
    };

    const handleSelectCategory = category => {
        dispatch({ type: 'select-category', payload: category });
        addedProducts.current && addedProducts.current.fetchDivisions(category);
    };

    const handleDeleteCategory = (categoryId: number): void => {
        const projectId = store.project.id;

        deleteCategory(projectId, categoryId)
            .then(response => {
                if (response.message) {
                    openNotificationWithIcon(
                        'error',
                        'Ошибка удаления категории',
                        'В категории есть добавленные товары',
                    );
                } else {
                    const respCategories = response.data;
                    dispatch({ type: 'set-project-categories', payload: respCategories });

                    const selectTarget = respCategories && !!respCategories.length && respCategories[0];
                    dispatch({
                        type: 'select-category',
                        payload: selectTarget,
                    });

                    addedProducts.current && addedProducts.current.fetchDivisions(selectTarget);
                }
            })
            .catch(err => {});
    };

    return (
        <div className="container mt-4 mb-3">
            <div className="row ">
                <div className="col-md-12">
                    <TabLinks id={store.project.id} links={links} />
                </div>
            </div>
            <div className="row mt-3">
                <div className="col-md-3">
                    <ul className="selected-categories">
                        {projectCategories.map(category => (
                            <li className="proj-products-list-item" key={category.id}>
                                <span
                                    className="proj-products-list-title"
                                    onClick={() => handleSelectCategory(category)}
                                >
                                    {category.name}
                                </span>
                                <span
                                    className="proj-products-list-icon"
                                    onClick={() => handleDeleteCategory(category.id)}
                                >
                                    {clearIcon}
                                </span>
                            </li>
                        ))}
                    </ul>
                    <hr />
                    <Dropdown
                        ref={categoriesRef}
                        values={categories}
                        isLoading={isLoading}
                        action={addCategory}
                        disableClear
                        defaultName="Добавить категорию"
                    />
                </div>
                <div className="col-md-9">
                    {selectedCategory && (
                        <AddedProducts
                            ref={addedProducts}
                            store={store}
                            category={selectedCategory}
                            projectId={store.project.id}
                        />
                    )}
                </div>
            </div>
        </div>
    );
}

export default PageLayout(ProjectProducts);
