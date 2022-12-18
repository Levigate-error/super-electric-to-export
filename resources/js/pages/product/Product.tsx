import * as React from 'react';
import { IProductPage } from './types';
import Slider from './components/Slider';
import Attributes from './components/Attributes';
import Instructions from './components/Instructions';
import Videos from './components/Videos';
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs';
import { UserContext } from '../../components/PageLayout/PageLayout';
import Button from '../../ui/Button';
import Modal from '../../ui/Modal';
import AddProduct from '../../ui/AddProduct';
import Spinner from '../../ui/Spinner';
import { getProjects, addToFavorites, removeFromFavorites } from './api';
import PageLayout from '../../components/PageLayout';
import AuthRegister from '../../components/AuthRegister';
import { FavoritesButton } from '../../ui/Favorites';
import Recommended from './components/Recommended';
import ByWithThis from './components/ByWithThis';

function reducer(state, action) {
    switch (action.type) {
        case 'open-add-modal':
            return {
                ...state,
                addModalIsVisible: true,
                addModalLoading: true,
                projects: [],
            };
        case 'set-projects':
            return {
                ...state,
                projects: action.payload,
                addModalLoading: false,
            };
        case 'close-add-modal':
            return {
                ...state,
                addModalIsVisible: false,
                addModalLoading: false,
            };
        case 'favorites-request':
            return { ...state, isFavorites: false, isLoading: true };
        case 'add-to-favorites':
            return { ...state, isFavorites: true, isLoading: false };
        case 'remove-from-favorites':
            return { ...state, isFavorites: false, isLoading: false };
        default:
            throw new Error();
    }
}

const addSpinerStyle = {
    margin: '0 auto',
};

function Product({
    store: {
        id,
        name,
        is_favorites,
        description,
        family,
        attributes,
        images,
        instructions,
        vendor_code,
        videos,
        recommended_retail_price,
        userResource,
        user,
    },
}: IProductPage) {
    const [{ addModalIsVisible, addModalLoading, projects, isLoading, isFavorites }, dispatch] = React.useReducer(
        reducer,
        {
            addModalIsVisible: false,
            addModalLoading: false,
            isFavorites: is_favorites,
            isLoading: false,
            projects: [],
        },
    );

    const userCtx = React.useContext(UserContext);

    const discriptionIsVisible = description !== '';
    const attributesIsVisible = !!attributes.length;
    const instructionsIsVisible = !!instructions.length;
    const videosIsVisible = !!videos.length;

    const handleOpenModal = React.useCallback(() => {
        dispatch({ type: 'open-add-modal' });
        getProjects().then(response => dispatch({ type: 'set-projects', payload: response.data.projects }));
    }, [addModalIsVisible, addModalLoading, projects]);

    const handleToggleFavoriteButton = React.useCallback(() => {
        if (userCtx.user) {
            dispatch({ type: 'favorites-request' });
            if (!isFavorites) {
                addToFavorites(id).then(response => {
                    const {
                        data: { error },
                    } = response;
                    if (!error) {
                        dispatch({ type: 'add-to-favorites' });
                    }
                });
            } else {
                removeFromFavorites(id).then(response => {
                    const {
                        data: { error },
                    } = response;
                    if (!error) {
                        dispatch({ type: 'remove-from-favorites' });
                    }
                });
            }
        }
    }, [isFavorites, isLoading]);

    const handleCloseModal = () => {
        dispatch({ type: 'close-add-modal' });
    };

    const modalContent = !addModalLoading ? (
        <AddProduct
            projects={projects}
            productId={id}
            closeModal={handleCloseModal}
            userResource={userCtx.userResource}
        />
    ) : (
        <Spinner style={addSpinerStyle} />
    );

    let lastProjectActivity: any = false;

    if (!Array.isArray(userResource)) {
        const project = userResource.activities.project;
        if (!Array.isArray(project)) {
            lastProjectActivity = project;
        }
    }

    const goToLastProject = id => {
        const base_url = window.location.origin;
        document.location.href = `${base_url}/project/specifications/${id}`;
    };

    return (
        <React.Fragment>
            {addModalIsVisible && (
                <Modal onClose={handleCloseModal} isOpen={addModalIsVisible} children={modalContent} />
            )}
            <div className="container product-detail-wrapper">
                <div className="row ">
                    <div className="col-md-5">
                        <Slider imagesData={images} />
                    </div>
                    <div className="col-md-7">
                        <div className="row">
                            <div className="col-md-12">
                                <h1 className="product-title">{name}</h1>
                                <div className="favorites-button-wrapper">
                                    <AuthRegister
                                        wrapped={
                                            <FavoritesButton
                                                disabled={isLoading}
                                                isActive={isFavorites}
                                                action={handleToggleFavoriteButton}
                                            />
                                        }
                                    ></AuthRegister>
                                </div>
                            </div>
                        </div>
                        <div className="row  mt-3">
                            <div className="col-md-12">
                                <span className="product-vendor-code">Артикул: {vendor_code}</span>
                            </div>
                        </div>
                        <div className="row  mt-1">
                            <div className="col-md-12">
                                <span className="series-wrapper">Серия: {family.name}</span>
                            </div>
                        </div>
                        <div className="row  mt-1">
                            <div className="col-md-12">
                                <span className="price-wrapper">
                                    Рекомендуемая розничная цена:
                                    <span>{recommended_retail_price} ₽</span>
                                </span>
                            </div>
                        </div>
                        <div className="row mt-3">
                            <div className="col-md-6">
                                <Button onClick={handleOpenModal} value="Добавить" />
                            </div>
                        </div>
                        <div className="row mt-3">
                            <div className="col-md-6">
                                {user && !!lastProjectActivity && (
                                    <button
                                        onClick={() => goToLastProject(lastProjectActivity.source_id)}
                                        className="legrand-text-btn back-to-proj-btn"
                                    >
                                        &#8592; Вернутся в проект
                                    </button>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {(discriptionIsVisible || attributesIsVisible || instructionsIsVisible || videosIsVisible) && (
                <div className="container-fluid product-info-wrpapper">
                    <div className="container">
                        <div className="row mt-3 ">
                            <div className="col-md-12">
                                <Tabs className="product-tabs">
                                    <TabList className="tabs-ul">
                                        {discriptionIsVisible && <Tab className="tabs-menu-item">О товаре</Tab>}
                                        {attributesIsVisible && <Tab className="tabs-menu-item">Характеристики</Tab>}
                                        {instructionsIsVisible && <Tab className="tabs-menu-item">Инструкции</Tab>}
                                        {videosIsVisible && <Tab className="tabs-menu-item">Видео</Tab>}
                                    </TabList>

                                    {discriptionIsVisible && (
                                        <TabPanel>
                                            <h3>Описание:</h3>
                                            <p>{description}</p>
                                        </TabPanel>
                                    )}
                                    {attributesIsVisible && (
                                        <TabPanel>
                                            <div className="tabs-content-item">
                                                <Attributes atrributes={attributes} />
                                            </div>
                                        </TabPanel>
                                    )}
                                    {instructionsIsVisible && (
                                        <TabPanel>
                                            <div className="tabs-content-item">
                                                <Instructions instructions={instructions} />
                                            </div>
                                        </TabPanel>
                                    )}
                                    {videosIsVisible && (
                                        <TabPanel>
                                            <div className="tabs-content-item">
                                                <Videos videos={videos} />
                                            </div>
                                        </TabPanel>
                                    )}
                                </Tabs>
                            </div>
                        </div>
                    </div>
                </div>
            )}
            <div className="container ">
                <div className="row">
                    <div className="col-12">
                        <ByWithThis productId={id} />
                    </div>
                </div>
            </div>
            <div className="container product-detail-last-section">
                <div className="row">
                    <div className="col-12">
                        <Recommended />
                    </div>
                </div>
            </div>
        </React.Fragment>
    );
}

export default PageLayout(React.memo(Product));
