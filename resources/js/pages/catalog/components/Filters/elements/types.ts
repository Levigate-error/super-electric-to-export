import { TSubcategory } from '../types';

export type TFilterCategory = {
    name: string;
    id: number;
    values: any[];
};

export interface ICategory {
    name: string;
    categoryId: number;
    values: TSubcategory[];
    selectFilter: (id: number, isChecked: boolean, categoryId: number) => void;
    checkedFilters: number[];
}
