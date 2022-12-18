import * as React from 'react';
import { defaultImgIcon } from '../../../../../ui/Icons/Icons';

interface ICategory {
    category: TCategory;
    filters: any;
}

type TCategory = {
    id: number;
    name: string;
    image: string;
};

const Category = ({ category, filters }: ICategory) => {
    const handleSelect = () => {
        filters.current && filters.current.handleSelectCategoryByDropdown(category);
    };

    return (
        <div className="col-auto categories-list-item-wrapper " onClick={handleSelect}>
            <div className="card categories-list-item">
                {category.image !== '' ? (
                    <img src={category.image} className="categories-list-item-img" />
                ) : (
                    defaultImgIcon
                )}
                <div className="categories-list-item-title">{category.name}</div>
            </div>
        </div>
    );
};

export default Category;
