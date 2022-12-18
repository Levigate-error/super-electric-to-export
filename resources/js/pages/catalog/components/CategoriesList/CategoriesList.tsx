import * as React from 'react';
import Category from './Category';

interface ICategoriesList {
    categories: TCategory[];
    filters: any;
}

type TCategory = {
    id: number;
    name: string;
    image: string;
};

const CategoriesList = ({ categories, filters }: ICategoriesList) => {
    return (
        <React.Fragment>
            {categories.map(category => (
                <Category category={category} filters={filters} key={category.id} />
            ))}
        </React.Fragment>
    );
};

export default CategoriesList;
