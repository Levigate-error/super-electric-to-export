import * as React from 'react';
import { UserContext } from '../../../../components/PageLayout/PageLayout';
import AuthRegister from '../../../../components/AuthRegister';
import { FavoritesButton } from '../../../../ui/Favorites';
import { reducer, actionTypes } from './reducer';
import { addToFavorites, removeFromFavorites } from '../Recommended/api';

interface IProduct {
    product: TProduct;
}

type TProduct = {
    id: number;
    name: string;
    vendor_code: string;
    img: string;
    is_favorites: boolean;
    attributes: TAttribute[];
};

type TAttribute = {
    title: string;
    value: string;
};

const errorImageStyle = {
    background: 'url(/images/default_product.jpg) no-repeat center center',
    backgroundSize: 'cover',
};

const normalImageStyle = {
    background: 'none',
};

const Product = ({
    product: { id, name, attributes, is_favorites, img, vendor_code },
}: IProduct): React.ReactElement => {
    const [{ isFavorites, isLoading, imgError }, dispatch] = React.useReducer(reducer, {
        isFavorites: is_favorites,
        isLoading: false,
        imgError: false,
    });

    const setDeafultImage = () => {
        dispatch({ type: actionTypes.IMG_ERROR });
    };

    const userCtx = React.useContext(UserContext);

    const handleToggleFavoriteButton = React.useCallback(() => {
        if (userCtx.user) {
            dispatch({ type: actionTypes.FAVORITES_REQUEST });
            if (!isFavorites) {
                addToFavorites(id).then(response => {
                    const {
                        data: { error },
                    } = response;
                    if (!error) {
                        dispatch({ type: actionTypes.ADD_TO_FAVORITES });
                    }
                });
            } else {
                removeFromFavorites(id).then(response => {
                    const {
                        data: { error },
                    } = response;
                    if (!error) {
                        dispatch({ type: actionTypes.REMOVE_FROM_FAVORITES });
                    }
                });
            }
        }
    }, [isFavorites, isLoading]);

    const imgStyle = imgError ? errorImageStyle : normalImageStyle;

    return (
        <div className="product-wrapper">
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
                        />
                    </div>

                    <a href={`catalog/product/${id}`}>
                        {!imgError && <img src={img} alt={name} onError={setDeafultImage} />}
                    </a>
                </div>

                <a href={`catalog/product/${id}`} className="product-title" title={name}>
                    {name}
                </a>
                <span className="product-vendor-code">Арт. {vendor_code}</span>
                <ProductParams attributes={attributes} />
            </div>
        </div>
    );
};

export default Product;

interface IProductParams {
    attributes: TAttribute[];
}

const ProductParams = ({ attributes }: IProductParams): React.ReactElement => {
    return (
        <ul className="product-params mt-3">
            {attributes.slice(0, 5).map(item => (
                <li className="product-param-row mt-2" key={item.title}>
                    <span>{item.title}:</span>
                    <span>{item.value}</span>
                </li>
            ))}
        </ul>
    );
};
