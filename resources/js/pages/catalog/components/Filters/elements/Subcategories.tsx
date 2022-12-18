import * as React from 'react';
import classnames from 'classnames';
import { ISubcategories, TSubcategory } from '../types';

import Checkbox from '../../../../../ui/Checkbox';

function Subcategories({ values, selectFilter, checkedFilters, isVisible, categoryId }: ISubcategories) {
    return (
        <div
            className={classnames('subcategories', {
                'subcategories-hidden': !isVisible,
            })}
        >
            {values.map((subcategory: TSubcategory) => {
                const { id, value, product_count } = subcategory;

                const label = (
                    <React.Fragment>
                        {value} <span className="catalog-subcategories-label"> ({product_count})</span>
                    </React.Fragment>
                );

                return (
                    <Checkbox
                        onChange={value => selectFilter(id, value, categoryId)}
                        data-id={id}
                        label={label}
                        checked={checkedFilters.includes(id)}
                        key={id}
                    />
                );
            })}
        </div>
    );
}

export default React.memo(Subcategories);
