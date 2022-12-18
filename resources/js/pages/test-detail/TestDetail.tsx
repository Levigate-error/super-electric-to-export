import * as React from 'react';
import PageLayout from '../../components/PageLayout';
import Test from './components/Test/Test';
import { TTest } from './types';
import { Icon } from 'antd';
// import { mock } from './mock';

interface ITestDetail {
    store: any;
}

interface IState {
    isLoading: boolean;
    test: TTest;
}

export class TestDetail extends React.Component<ITestDetail, IState> {
    state = {
        isLoading: false,
        test: this.props.store.test,
    };

    render() {
        const { isLoading, test } = this.state;

        return (
            <div className="container test-detail-wrapper">
                {isLoading ? (
                    <div className="test-list-page-preloader-wrapper">
                        <Icon type="loading" className="test-list-page-preloader" />
                    </div>
                ) : (
                    <div className="row mt-4">
                        <div className="col-12">
                            <Test data={test} />
                        </div>
                    </div>
                )}
            </div>
        );
    }
}

export default PageLayout(TestDetail);
