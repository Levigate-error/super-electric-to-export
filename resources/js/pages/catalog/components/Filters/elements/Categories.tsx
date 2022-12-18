import * as React from 'react';
import { ICategories, TCategory } from '../types';

import Category from './Category';

function Categories({ filtersData, selectFilter, checkedFilters }: ICategories) {
    return (
        <React.Fragment>
            {filtersData.map((filter: TCategory) => {
                const { name, id, values } = filter;

                return (
                    <Category
                        key={id}
                        categoryId={id}
                        name={name}
                        values={values}
                        selectFilter={selectFilter}
                        checkedFilters={checkedFilters}
                    />
                );
            })}
        </React.Fragment>
    );
}

export default React.memo(Categories);
