import * as React from 'react';
import classnames from 'classnames';
import Product from '../Product';
import { IProducts } from './types';
import { TProduct } from '../Product/types';

function Products({ showAsRows, products }: IProducts) {
    return (
        <div className={classnames(showAsRows ? 'products-container-rows' : 'products-container-gird')}>
            {products.map((product: TProduct) => {
                return <Product showAsRows={showAsRows} product={product} key={product.id} />;
            })}
        </div>
    );
}

export default React.memo(Products);
