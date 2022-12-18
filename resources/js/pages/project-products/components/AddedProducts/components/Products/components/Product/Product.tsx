import * as React from 'react';
import { ProductParams } from './elements/ProductParams';
import Input from '../../../../../../../../ui/Input';
import Spinner from '../../../../../../../../ui/Spinner';
import { reducer } from './reducer';
import { Icon } from 'antd';
import { removeProduct } from './api';

interface IProduct {
    product: any;
    showAsRows: boolean;
    changeProductAmount: (productId: number, amount: number) => void;
    updateProducts: () => void;
    projectId: number;
}

const errorImageStyle = {
    background: 'url(/images/default_product.jpg) no-repeat center center',
    backgroundSize: 'cover',
};

const normalImageStyle = {
    background: 'none',
};

const Product = ({ product, changeProductAmount, updateProducts, projectId }: IProduct) => {
    const [{ imgError, amount, fetch }, dispatch] = React.useReducer(reducer, {
        imgError: false,
        fetch: false,
        amount: product.amount,
    });

    const setDeafultImage = () => {
        dispatch({ type: 'imgLoadingError' });
    };

    const handleChangeCount = e => {
        const value = parseInt(e.target.value);
        dispatch({ type: 'changeAmount', payload: value || '' });

        const amount = !value || value <= 0 ? 1 : value;
        changeProductAmount(product.id, amount);
    };

    const handleRemoveProduct = async () => {
        dispatch({ type: 'fetch' });
        await removeProduct({ project_id: projectId, product_id: product.id });
        updateProducts();
    };

    const imgStyle = imgError ? errorImageStyle : normalImageStyle;

    return (
        <div className="product-wrapper">
            <div className="product">
                <div className="product-photo" style={imgStyle}>
                    <div className="delete-button-wrapper">
                        <Icon type="close-circle" onClick={handleRemoveProduct} />
                    </div>
                    <img src={product.img} alt={product.name} onError={setDeafultImage} />
                </div>

                <a href={`/catalog/product/${product.id}`} className="product-title">
                    {product.name}
                </a>
                <span className="product-vendor-code">Арт. {product.vendor_code}</span>
                <ProductParams params={product.attributes} />
            </div>
            <span className="catalog-product-cost">{product.recommended_retail_price} ₽</span>
            <div className="product-count">
                <Input onChange={handleChangeCount} value={amount} />
            </div>
            {fetch && <Spinner />}
        </div>
    );
};

export default Product;
