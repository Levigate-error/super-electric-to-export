import * as React from 'react';
import { Modal, Icon } from 'antd';
import SelectScreen from './components/SelectScreen';
import Analog from './components/Analog';
import { getAnalogsRequest } from './api';

interface IState {
    analogIsVisible: boolean;
    projectsAvailable: boolean;
    analogFetch: boolean;
    addRequest: boolean;
    analog: any;
    analogNotFound: boolean;
    article: string;
    analogs: any[];
}

interface ISelectionAnalog {
    isOpen: boolean;
    onClose: () => void;
    user: any;
}

const initialState = {
    analogIsVisible: false,
    projectsAvailable: false,
    analogFetch: false,
    addRequest: false,
    analog: undefined as any,
    analogNotFound: false,
    article: '', // example 2CSR145001R1164
    analogs: [] as any,
};
export class SelectionAnalog extends React.Component<ISelectionAnalog, IState> {
    state = initialState;

    handleChangeArticle = (val: string): void => this.setState({ article: val });

    handleFetchAnalog = () => {
        const { article } = this.state;

        this.setState({ analogFetch: true });
        getAnalogsRequest(article)
            .then(response => {
                this.setState({
                    analogFetch: false,
                    analogIsVisible: true,
                    analog: response.data[0],
                    analogs: response.data,
                });
            })
            .catch(error => {
                this.setState({ analogFetch: false, analog: undefined, analogNotFound: true });
            });
    };

    handleBack = () => this.setState(initialState);

    render() {
        const { user, onClose, isOpen } = this.props;
        const { analogIsVisible, analogNotFound, article, analogFetch, analog } = this.state;

        return (
            <Modal onCancel={onClose} visible={isOpen} footer={false}>
                {analogIsVisible ? (
                    <React.Fragment>
                        <Icon type="arrow-left" className="selection-analog-back-btn" onClick={this.handleBack} />
                        <Analog user={user} product={analog?.products?.[0]} />
                    </React.Fragment>
                ) : (
                    <SelectScreen
                        article={article}
                        changeArticle={this.handleChangeArticle}
                        findAnalog={this.handleFetchAnalog}
                        analogIsLoading={analogFetch}
                        analogNotFound={analogNotFound}
                    />
                )}
            </Modal>
        );
    }
}

export default SelectionAnalog;
