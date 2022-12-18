import * as React from 'react';
import TestAnswers from './TestAnswers';
import Button from '../../../../../ui/Button';

interface ITestPage {
    nextStep: () => void;
    test: any;
    currentPage: number;
    addUserAnswers: (questionAnswers: any) => void;
    finishTest: () => void;
}

interface IState {
    answers: number[];
    answersIsApply: boolean;
}

type TRadio = {
    id: number;
    value: number;
    text: string;
    detail?: string;
};

export class TestPage extends React.Component<ITestPage, IState> {
    state = {
        answers: [],
        answersIsApply: false,
    };

    answersRef = React.createRef<TestAnswers>();

    prepareData = (): TRadio[] => {
        const { test, currentPage } = this.props;

        const values = test.questions[currentPage].answers.map(item => ({
            id: item.id,
            value: item.id,
            text: item.answer,
            detail: item.description,
            isCorrect: item.is_correct,
        }));

        return values;
    };

    handleChangeAnswer = (isChecked, answer): void => {
        const { answers } = this.state;
        this.setState({ answers: isChecked ? [...answers, answer.id] : answers.filter(el => el !== answer.id) });
    };

    handleAcceptAnswers = (): void => {
        const { test, currentPage, addUserAnswers } = this.props;
        const { answers } = this.state;
        this.setState({ answersIsApply: true });
        addUserAnswers({
            id: test.questions[currentPage].id,
            answers: answers.map(item => ({ id: item })),
        });
    };

    handleNextStep = (): void => {
        const { nextStep } = this.props;

        nextStep();
        this.setState({ answers: [], answersIsApply: false });
    };

    render() {
        const { test, currentPage, finishTest } = this.props;
        const { answers, answersIsApply } = this.state;

        const question = test.questions[currentPage];

        const isLastQuestion = currentPage + 1 === test.questions.length;

        return (
            <div className="test-page-wrapper">
                {!!question && (
                    <React.Fragment>
                        <div className="test-page-image-wrapper mt-3">
                            <div className="test-page-image-counter">{`${currentPage + 1}/${
                                test.questions.length
                            }`}</div>
                            {(question.image || test.image) && (
                                <img src={question.image || test.image} className="test-page-image" />
                            )}
                        </div>
                        <div className="test-page-question-title mt-3">{question.question}</div>
                        <div className="test-page-radio-wrapper mt-3">
                            <TestAnswers
                                answers={this.prepareData()}
                                onChange={this.handleChangeAnswer}
                                ref={this.answersRef}
                                selected={answers}
                                answersIsApply={answersIsApply}
                            />
                        </div>
                        {answersIsApply ? (
                            <Button
                                onClick={isLastQuestion ? finishTest : this.handleNextStep}
                                appearance="accent"
                                value={isLastQuestion ? 'Показать результат' : 'Следующий вопрос'}
                                className="mt-3"
                            />
                        ) : (
                            <Button
                                onClick={this.handleAcceptAnswers}
                                appearance="accent"
                                value="Применить"
                                className="mt-3"
                                disabled={!answers.length}
                            />
                        )}
                    </React.Fragment>
                )}
            </div>
        );
    }
}

export default TestPage;
