import * as React from 'react';
import classnames from 'classnames';

interface ITestAnswers {
    answers: any[];
    onChange: (isChecked: any, answer: any) => void;
    selected: number[];
    answersIsApply: boolean;
}

interface IState {
    selected: number[];
}

export class TestAnswers extends React.Component<ITestAnswers, IState> {
    render() {
        const { answers, selected, onChange, answersIsApply } = this.props;

        return answers.map(answer => {
            return (
                <div className="answers-wrapper" key={answer.id}>
                    <AnswerRow
                        answer={answer}
                        selected={selected.find(id => answer.id === id)}
                        changeAnswer={onChange}
                        answersIsApply={answersIsApply}
                    />
                </div>
            );
        });
    }
}

export default TestAnswers;

const AnswerRow = ({ answer, selected, changeAnswer, answersIsApply }) => {
    const handleSelect = e => {
        const isChecked = e.target.checked;
        changeAnswer(isChecked, answer);
    };

    const isCorrect = answersIsApply && answer.isCorrect && !!selected;
    const disabledRow = answersIsApply && !isCorrect && !selected;
    const wrongAnswer = answersIsApply && ((answer.isCorrect && !selected) || (!answer.isCorrect && !!selected));

    return (
        <label
            className={classnames(
                'ui-checkbox test-checkbox',
                { 'test-checkbox-correct': isCorrect },
                { 'test-checkbox-wrong': wrongAnswer },
                { 'test-checkbox-disabled': disabledRow },
            )}
        >
            <div>
                {answer.text}
                {(isCorrect || wrongAnswer) && <span className="test-detail-anser-row-detail">{answer.detail}</span>}
            </div>

            <input type="checkbox" checked={!!selected} onChange={handleSelect} name={name} />
            <span
                className={classnames('checkmark test-checkmark', {
                    'test-radio-checkmark-correct': isCorrect,
                    'test-radio-checkmark-wrong': wrongAnswer,
                    'test-radio-checkmark-disabled': disabledRow,
                })}
            />
        </label>
    );
};
