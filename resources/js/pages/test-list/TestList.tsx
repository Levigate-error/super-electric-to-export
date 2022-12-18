import * as React from 'react';
import PageLayout from '../../components/PageLayout';
import TestItem from './components/TestItem';
import { getTestsList } from './api';
import { Icon } from 'antd';

interface ITestList {
    store: any;
}

interface IState {
    testsList: any;
    isLoading: boolean;
}

export class VideoList extends React.Component<ITestList, IState> {
    state = {
        testsList: [],
        isLoading: true,
    };

    componentDidMount() {
        getTestsList()
            .then(response => {
                this.setState({ testsList: response.data, isLoading: false });
            })
            .catch(err => {
                this.setState({ isLoading: false });
            });
    }
    render() {
        const { testsList, isLoading } = this.state;
        return (
            <div className="container test-list-wrapper">
                <div className="row mt-4">
                    <div className="col-12">
                        <h3>Тесты</h3>
                    </div>
                </div>
                {!isLoading ? (
                    <div className="row mt-3">
                        {testsList.map(test => (
                            <TestItem test={test} key={test.id} />
                        ))}
                    </div>
                ) : (
                    <div className="test-list-page-preloader-wrapper">
                        <Icon type="loading" className="test-list-page-preloader" />
                    </div>
                )}
            </div>
        );
    }
}

export default PageLayout(VideoList);
