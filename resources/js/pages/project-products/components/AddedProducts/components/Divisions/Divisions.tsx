import * as React from 'react';
import { addCircle, electroWhiteBackground } from '../../../../../../ui/Icons/Icons';

interface IDivisions {
    divisions: TDivision[];
    categoryId: number;
    selectAction: (item: any) => void;
}

type TDivision = {
    id: number;
    name: string;
    product_amount: number;
};

const Divisions = ({ divisions, selectAction, categoryId }: IDivisions) => {
    const addDivisionitem = () => {
        const baseUrl = window.location.origin;
        window.location.href = `${baseUrl}/catalog?category_id=${categoryId}`;
    };

    return (
        <React.Fragment>
            <div className="division-item division-item-add-wrapper">
                <button className="add-division-product-btn" onClick={addDivisionitem}>
                    {addCircle}
                </button>
            </div>
            {divisions.map(
                item =>
                    !!item.product_amount && (
                        <div className="division-item" key={item.name} onClick={() => selectAction(item)}>
                            <div className="division-product-img-wrapper">{electroWhiteBackground}</div>
                            <div className="division-name">{item.name}</div>

                            <div className="division-amount">{item.product_amount}</div>
                        </div>
                    ),
            )}
        </React.Fragment>
    );
};

export default Divisions;
