import * as React from 'react';
import Subcategories from './Subcategories';
import { ICategory } from './types';
import { chevronDown, chevronUp } from '../../../../../ui/Icons/Icons';

function Category({ name, values, selectFilter, checkedFilters, categoryId }: ICategory) {
    const [isVisible, setIsVisible] = React.useState(false);

    const handleClick = React.useCallback(() => {
        setIsVisible(!isVisible);
    }, [isVisible]);

    return (
        <div className="filter-category">
            <div className="category" onClick={handleClick}>
                <span>{name}</span>
                <span>{isVisible ? chevronUp : chevronDown}</span>
            </div>
            <Subcategories
                isVisible={isVisible}
                categoryId={categoryId}
                selectFilter={selectFilter}
                values={values}
                checkedFilters={checkedFilters}
            />
        </div>
    );
}

export default React.memo(Category);
