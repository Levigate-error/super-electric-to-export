import * as React from 'react';
import { IProject } from './types';
import GeneralInformation from './components/GeneralInformation';
import TabLinks from '../../ui/TabLinks';
import PageLayout from '../../components/PageLayout';

const links = [
    {
        url: '/project/update',
        title: 'Общая информация',
        selected: true,
    },
    {
        url: '/project/products',
        title: 'Добавленная продукция',
        selected: false,
    },
    {
        url: '/project/specifications',
        title: 'Спецификация',
        selected: false,
    },
];

function ProjectForm({ store }: IProject) {
    return (
        <div className="container mt-4 mb-3">
            <div className="row ">
                <div className="col-md-12">
                    <TabLinks id={store.project.id} links={links} />
                </div>
            </div>
            <div className="row ">
                <div className="col-md-12">
                    <GeneralInformation store={store} />
                </div>
            </div>
        </div>
    );
}

export default PageLayout(ProjectForm);
