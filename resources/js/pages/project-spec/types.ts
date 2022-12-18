export interface ISpecification {
    isLoading: boolean;
    sections: any; // TODO: add types
    specification: any;
    projectId: number;
    setSections: (data: any[]) => void;
    updateSpec: (id: number) => void;
}
export interface IProjectSpec {
    store: any;
}
