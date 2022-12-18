import * as React from 'react';
import { IAddedProducts } from '../../types';
import { fetchCategoryDivisions } from './api';
import Divisions from './components/Divisions';
import Products from './components/Products';

export class AddedProducts extends React.Component<IAddedProducts> {
    state = {
        isLoading: false,
        selectedDivision: null,
        divisions: [],
    };

    fetchDivisions = category => {
        const { projectId } = this.props;
        this.setState({ isLoading: true, selectedDivision: null });

        fetchCategoryDivisions({
            project_id: projectId,
            category_id: category.id,
        }).then(response => {
            this.setState({ divisions: response, isLoading: false });
        });
    };

    componentDidMount() {
        const { category } = this.props;

        this.fetchDivisions(category);
    }

    handleSelectDivision = division => {
        if (division.product_amount === 0) {
            const baseUrl = window.location.origin;
            document.location.href = baseUrl + `/catalog?division_id=${division.id}`;
        } else {
            this.setState({ selectedDivision: division });
        }
    };

    handleBackToDivision = async () => {
        const { category } = this.props;

        await this.fetchDivisions(category);
        this.setState({ selectedDivision: null });
    };

    render() {
        const { category, projectId } = this.props;
        const { selectedDivision, divisions, isLoading } = this.state;

        const divisionsIsVisible = !selectedDivision;

        return (
            <React.Fragment>
                {divisionsIsVisible && (
                    <div className="row">
                        <div className="col-12  mt-sm-3 mt-md-0">
                            <h3>{category.name}</h3>
                        </div>
                    </div>
                )}
                <div className="products-divisions-wrapper mt-3">
                    {!isLoading && divisionsIsVisible && (
                        <div className="added-products-wrapper">
                            <Divisions
                                categoryId={category.id}
                                divisions={divisions}
                                selectAction={this.handleSelectDivision}
                            />
                        </div>
                    )}
                    {!isLoading && !divisionsIsVisible && (
                        <div className="added-products-wrapper">
                            <Products
                                projectId={projectId}
                                category={category}
                                division={selectedDivision}
                                back={this.handleBackToDivision}
                            />
                        </div>
                    )}
                </div>
            </React.Fragment>
        );
    }
}

export default AddedProducts;
