import * as React from 'react';
import PageLayout from '../../components/PageLayout';
import FAQRow from './components/FAQRow';
import { getFaq } from './api';
import Feedback from '../../components/Feedback';
import Button from '../../ui/Button';

interface IFAQ {
    store: any;
}

interface IState {
    faqs: TFaq[];
    modalIsOpen: boolean;
}

type TFaq = {
    id: number;
    question: string;
    answer: string;
    created_at: string;
};

export class FAQ extends React.Component<IFAQ, IState> {
    state = {
        faqs: [],
        modalIsOpen: false,
    };

    handleToggleModal = () => this.setState({ modalIsOpen: !this.state.modalIsOpen });

    handleGetFaq = () => {
        getFaq({})
            .then(response => {
                if (response.data) {
                    this.setState({ faqs: response.data.faqs });
                }
            })
            .catch(err => {});
    };

    componentDidMount() {
        this.handleGetFaq();
    }

    render() {
        const { faqs, modalIsOpen } = this.state;

        return (
            <div className="container faq-wrapper ">
                <div className="row mt-4">
                    <div className="col-12">
                        <h3>Помощь</h3>
                    </div>
                </div>
                <div className="row mt-3">
                    <div className="col-12">
                        <h3 className="faq-page-title mt-3">Часто задаваемые вопросы</h3>
                    </div>
                </div>
                <div className="row mt-3">
                    <div className="col-sm-12 col-md-8">
                        {faqs.map(item => (
                            <FAQRow row={item} key={item.id} />
                        ))}
                    </div>
                </div>
                <div className="row mt-3">
                    <div className="col-12">
                        {modalIsOpen && (
                            <Feedback isOpen={modalIsOpen} onClose={this.handleToggleModal} type="common" />
                        )}
                        <Button onClick={this.handleToggleModal} value="Задать вопрос" appearance="accent" />
                    </div>
                </div>
            </div>
        );
    }
}

export default PageLayout(FAQ);
