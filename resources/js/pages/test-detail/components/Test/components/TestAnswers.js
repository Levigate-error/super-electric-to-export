"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
class TestAnswers extends React.Component {
    render() {
        const { answers, selected, onChange, answersIsApply } = this.props;
        return answers.map(answer => {
            return (React.createElement("div", { className: "answers-wrapper", key: answer.id },
                React.createElement(AnswerRow, { answer: answer, selected: selected.find(id => answer.id === id), changeAnswer: onChange, answersIsApply: answersIsApply })));
        });
    }
}
exports.TestAnswers = TestAnswers;
exports.default = TestAnswers;
const AnswerRow = ({ answer, selected, changeAnswer, answersIsApply }) => {
    const handleSelect = e => {
        const isChecked = e.target.checked;
        changeAnswer(isChecked, answer);
    };
    const isCorrect = answersIsApply && answer.isCorrect && !!selected;
    const disabledRow = answersIsApply && !isCorrect && !selected;
    const wrongAnswer = answersIsApply && ((answer.isCorrect && !selected) || (!answer.isCorrect && !!selected));
    return (React.createElement("label", { className: classnames_1.default('ui-checkbox test-checkbox', { 'test-checkbox-correct': isCorrect }, { 'test-checkbox-wrong': wrongAnswer }, { 'test-checkbox-disabled': disabledRow }) },
        React.createElement("div", null,
            answer.text,
            (isCorrect || wrongAnswer) && React.createElement("span", { className: "test-detail-anser-row-detail" }, answer.detail)),
        React.createElement("input", { type: "checkbox", checked: !!selected, onChange: handleSelect, name: name }),
        React.createElement("span", { className: classnames_1.default('checkmark test-checkmark', {
                'test-radio-checkmark-correct': isCorrect,
                'test-radio-checkmark-wrong': wrongAnswer,
                'test-radio-checkmark-disabled': disabledRow,
            }) })));
};
