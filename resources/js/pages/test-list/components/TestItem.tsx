import * as React from 'react';
import { num2str } from '../../../utils/utils';

interface ITestItem {
    test: TTest;
}

type TTest = {
    id: number;
    title: string;
    description: string;
    questions: any[];
    image: string;
};

const TestItem = ({ test }: ITestItem) => {
    return (
        <a className="col-auto mb-3" href={`/test/${test.id}`}>
            <div className="card test-list-item">
                <div className="test-list-item-img-wrapper">
                    <div className="test-list-item-img" style={{ backgroundImage: `url(${test.image})` }}></div>
                </div>
                <div className="test-list-item-title">{test.title}</div>
                <div className="test-list-item-count">
                    {test.questions.length} {num2str(test.questions.length, ['вопрос', 'вопроса', 'вопросов'])}
                </div>
            </div>
        </a>
    );
};

export default TestItem;
