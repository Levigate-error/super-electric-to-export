import * as React from 'react';
import debounce from '../../../../../../utils/debounce.js'
import { fetchDivisionProducts } from '../../api';
import Spinner from '../../../../../../ui/Spinner';
import Product from './components/Product';
import { updateProduct } from './api';
import { displayBars, displayGrid } from '../../../../../../ui/Icons/Icons';
import { Icon } from 'antd';
import { reducer } from './reducer';
import { addCircle } from '../../../../../../ui/Icons/Icons';

interface IProducts {
    projectId: number;
    division: TDivision;
    category: TCategory;
    back: () => void;
}

type TCategory = {
    name: string;
    id: number;
};

type TDivision = {
    id: number;
    name: string;
};

const btnBackStyle = {
    fontSize: '28px',
    marginRight: '10px',
    verticalAlign: 'baseline',
};

const Products = ({ projectId, category, division, back }: IProducts) => {
    const [{ isLoading, products, showAsRows }, dispatch] = React.useReducer(reducer, {
        isLoading: true,
        showAsRows: false,
        selectedDivision: null,
        divisions: [],
    });

    React.useEffect(() => {
        handleUpdateProducts();
    }, []);

    const handleAddProduct = () => {
        const base_url = window.location.origin;
        window.location.href = `${base_url}/catalog?category_id=${category.id}&division_id=${division.id}`;
    };

    const changeProductAmount = debounce((productId, amount) => {
        dispatch({ type: 'fetch' });

        const params = {
            amount,
        };

        updateProduct(params, projectId, productId)
            .then(({ data }) => {
                data.result &&
                    fetchDivisionProducts({
                        project_id: projectId,
                        division_id: division.id,
                    }).then(response => {
                        dispatch({ type: 'select-products', payload: response });
                    });
            })
            .catch(err => {});
    }, 2000);

    const handleChangeDisplayFormat = () => dispatch({ type: 'change-display-format' });

    const handleUpdateProducts = () => {
        dispatch({ type: 'fetch' });
        fetchDivisionProducts({
            project_id: projectId,
            division_id: division.id,
        }).then(response => {
            dispatch({ type: 'select-products', payload: response });
        });
    };

    return (
        <React.Fragment>
            <div className="products-title-row">
                <Icon type="left-square" onClick={back} style={btnBackStyle} />

                {division.name}
                <button className="show-as-row-btn" onClick={handleChangeDisplayFormat}>
                    {showAsRows ? displayGrid : displayBars}
                </button>
            </div>

            <div className={showAsRows ? 'products-container-rows' : 'products-container-gird'}>
                <div className="prodict-item-add-wrapper">
                    <button className="add-product-product-btn" onClick={handleAddProduct}>
                        {addCircle}
                    </button>
                </div>
                {!isLoading ? (
                    products.map(product => (
                        <Product
                            showAsRows={showAsRows}
                            product={product}
                            key={product.id}
                            changeProductAmount={changeProductAmount}
                            updateProducts={handleUpdateProducts}
                            projectId={projectId}
                        />
                    ))
                ) : (
                    <div className="spinner-wrapper">
                        <Spinner />
                    </div>
                )}
            </div>
        </React.Fragment>
    );
};

export default Products;
