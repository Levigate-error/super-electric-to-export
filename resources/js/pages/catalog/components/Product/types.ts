export interface IProduct {
    product: TProduct;
    showAsRows: boolean;
}

export type TProduct = {
    attributes: TProductAttribute[];
    id: number;
    img: string;
    is_favorites: boolean;
    min_amount: number;
    name: string;
    recommended_retail_price: string;
    unit: number;
    vendor_code: string;
};

export type TProductAttribute = {
    title: string;
    value: string | number;
};

export interface IParams {
    params: TProductAttribute[];
}
