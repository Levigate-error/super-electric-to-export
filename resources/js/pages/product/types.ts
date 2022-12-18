export interface IProductPage {
    store: any;
}

export type TProduct = {
    id: number;
    name: string;
    description: string;
    is_favorites: boolean;
    family: any;
    division: any;
    img: string;
    attributes: any[];
    images: any[];
    instructions: any[];
    vendor_code: string;
    recommended_retail_price: string;
    videos: any[];
    user: any;
    userResource: any;
};
