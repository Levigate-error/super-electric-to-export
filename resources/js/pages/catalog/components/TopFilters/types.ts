export interface ITopFilters {
    showAsRows: boolean;
    favoritesSelected: boolean;
    actions: TActions;
    productsSort: boolean;
    textFilterLoading: boolean;
    productsIsLoading: boolean;
    sortColumn: string;
}

type TActions = {
    onToggleFavorites: () => void;
    onChangeDisplayFormat: () => void;
    onChangeSortColumn: (value: string) => void;
    onSortByPriceAsc: () => void;
    onSortByPriceDesc: () => void;
    onSortByRate: () => void;
};
