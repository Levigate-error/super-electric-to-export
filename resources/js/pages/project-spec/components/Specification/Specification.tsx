import * as React from 'react';
import { ISpecification } from '../../types';
import SpecTable from './components/SpecTable/SpecTable';
import AddProduct from '../Specification/components/AddProduct/AddProduct';
import Spinner from '../../../../ui/Spinner';
import classnames from 'classnames';

const specSpinnerStyle = {
    position: 'absolute',
    zIndex: 2,
    left: 'calc(50% - 32px)',
    top: 'calc(50% - 32px)',
};

export function Specification({
    sections = [],
    specification,
    setSections,
    projectId,
    updateSpec,
    isLoading,
}: ISpecification) {
    return (
        <div className={classnames('spec-table-wrapper', 'mt-3 mt-md-0')}>
            {isLoading && <Spinner style={specSpinnerStyle} />}

            <div
                className={classnames('spec-tables-wrapper', {
                    'spec-table-wrapper-loading': isLoading,
                })}
            >
                {sections.map(section => (
                    <div
                        id={`section-${section.id}`}
                        className={isLoading ? 'loading-section' : 'loaded-section'}
                        key={section.id || 'fake_section'}
                    >
                        <SpecTable
                            section={section}
                            sections={sections}
                            specification={specification}
                            setSections={setSections}
                            projectId={projectId}
                            updateSpec={updateSpec}
                            isLoading={isLoading}
                        />
                        <AddProduct
                            projectId={projectId}
                            section={section}
                            updateSpec={updateSpec}
                            specificationId={specification.id}
                        />
                    </div>
                ))}
            </div>
        </div>
    );
}

export default Specification;
