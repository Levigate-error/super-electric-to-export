import * as React from 'react';
import classnames from 'classnames';
import { FavoritesButton } from '../../../../ui/Favorites';
import { IProduct } from './types';
import { ProductParams } from './elements/ProductParams';
import { addToFavorites, removeFromFavorites, getProjects } from './api';
import Button from '../../../../ui/Button';
import Modal from '../../../../ui/Modal';
import AuthRegister from '../../../../components/AuthRegister';
import AddProduct from '../../../../ui/AddProduct';
import Spinner from '../../../../ui/Spinner';
import { UserContext } from '../../../../components/PageLayout/PageLayout';

function reducer(state, action) {
    switch (action.type) {
        case 'favoritesRequest':
            return { ...state, isLoading: true };
        case 'addToFavorites':
            return { ...state, isFavorites: true, isLoading: false };
        case 'removeFromFavorites':
            return { ...state, isFavorites: false, isLoading: false };
        case 'imgLoadingError':
            return { ...state, imgError: true };
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
        default:
            return state;
    }
}

const addSpinerStyle = {
    height: 100,
    width: '100%',
    display: 'flex',
    justifyContent: 'center',
};
const errorImageStyle = {
    background: 'url(images/default_product.jpg) no-repeat center center',
    backgroundSize: 'cover',
};

const normalImageStyle = {
    background: 'none',
};

function Product({ product, showAsRows }: IProduct) {
    const [
        { isFavorites, isLoading, imgError, addModalIsVisible, addModalLoading, projects },
        dispatch,
    ] = React.useReducer(reducer, {
        isFavorites: product.is_favorites,
        isLoading: false,
        imgError: false,
        addModalIsVisible: false,
        addModalLoading: false,
        projects: [],
    });

    const userCtx = React.useContext(UserContext);

    const handleToggleFavoriteButton = React.useCallback(() => {
        if (userCtx.user) {
            dispatch({ type: 'favoritesRequest' });
            if (!isFavorites) {
                addToFavorites(product.id).then(response => {
                    const {
                        data: { error },
                    } = response;
                    if (!error) {
                        dispatch({ type: 'addToFavorites' });
                    }
                });
            } else {
                removeFromFavorites(product.id).then(response => {
                    const {
                        data: { error },
                    } = response;
                    if (!error) {
                        dispatch({ type: 'removeFromFavorites' });
                    }
                });
            }
        }
    }, [isFavorites, isLoading]);

    const setDeafultImage = () => {
        dispatch({ type: 'imgLoadingError' });
    };

    const handleOpenModal = React.useCallback(() => {
        dispatch({ type: 'open-add-modal' });
        getProjects().then(response => dispatch({ type: 'set-projects', payload: response.data.projects }));
    }, [addModalIsVisible, addModalLoading, projects]);

    const handleCloseModal = () => {
        dispatch({ type: 'close-add-modal' });
    };

    const imgStyle = imgError ? errorImageStyle : normalImageStyle;

    const modalContent = !addModalLoading ? (
        <AddProduct
            projects={projects}
            productId={product.id}
            closeModal={handleCloseModal}
            userResource={userCtx.userResource}
        />
    ) : (
        <Spinner style={addSpinerStyle} />
    );

    return (
        <div className="product-wrapper">
            {addModalIsVisible && (
                <Modal onClose={handleCloseModal} isOpen={addModalIsVisible} children={modalContent} />
            )}
            <div className="product">
                <div className="product-photo" style={imgStyle}>
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

                    <a href={`catalog/product/${product.id}`}>
                        {!imgError && <img src={product.img} alt={product.name} onError={setDeafultImage} />}
                    </a>
                </div>

                <a href={`catalog/product/${product.id}`} className="product-title" title={product.name}>
                    {product.name}
                </a>
                <span className="product-vendor-code">Арт. {product.vendor_code}</span>
                <ProductParams params={product.attributes} />
            </div>
            <span className="catalog-product-cost">{product.recommended_retail_price} ₽</span>
            <Button
                onClick={handleOpenModal}
                appearance="accent"
                value="Добавить"
                className={classnames(showAsRows ? 'product-row-btn' : 'product-grid-btn')}
            />
        </div>
    );
}

export default React.memo(Product);
