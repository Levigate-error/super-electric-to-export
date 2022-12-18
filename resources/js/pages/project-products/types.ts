export interface IProjectProducts {
    store: any; // TODO: add types
}
export interface IAddedProducts {
    store: any;
    category: TCategory;
    projectId: number;
}

type TCategory = {
    id: number;
    name: string;
};
