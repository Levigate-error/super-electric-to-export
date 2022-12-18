import * as React from 'react';
import TestPage from './components/TestPage';
import { reducer, initialState, actionTypes } from './reducer';
import Button from '../../../../ui/Button';
import { Icon } from 'antd';
import { registerResult } from '../../api';
import AuthRegister from '../../../../components/AuthRegister';
import { UserContext } from '../../../../components/PageLayout/PageLayout';

interface ITest {
    data: any;
}

const Test = ({ data }: ITest) => {
    const [
        { currentPage, inProgress, userAnswers, resultData, publishRequest, publishError },
        dispatch,
    ] = React.useReducer(reducer, initialState);

    const userCtx = React.useContext(UserContext);
    const isAuth = !(Array.isArray(userCtx.userResource) && userCtx.userResource.length === 0);

    const nextStep = (): void => dispatch({ type: actionTypes.SET_PAGE, payload: currentPage + 1 });
    const addUserAnswers = (questionAnswers): void =>
        dispatch({ type: actionTypes.ADD_ANSWERS, payload: questionAnswers });

    const handleStartTest = (): void => {
        isAuth && dispatch({ type: actionTypes.START_TEST });
    };

    const handleFinishTest = () => {
        nextStep();
        dispatch({ type: actionTypes.PUBLISH_REQUEST });
        registerResult({ id: data.id, questions: userAnswers })
            .then(response => {
                dispatch({ type: actionTypes.PUBLISH_SUCCESS, payload: response.data });
            })
            .catch(err => {
                dispatch({ type: actionTypes.PUBLISH_FAILURE, payload: err.message });
            });
    };

    return (
        <div className="test-wrapper">
            <div className="row mt-3">
                <div className="col-12">
                    <h3 className="test-title">Тест: {data.title}</h3>
                </div>
            </div>
            <div className="row justify-content-md-center">
                <div className="col-12 col-md-8">
                    {!inProgress && (
                        <div className="test-page-wrapper">
                            <div className="test-page-image-wrapper mt-3">
                                {data.image && <img src={data.image} className="test-page-image" />}
                            </div>
                            <div className="test-page-start-description mt-3">{data.description}</div>
                            <div className="test-page-start-button-wrapper">
                                {isAuth ? (
                                    <Button
                                        onClick={handleStartTest}
                                        appearance="accent"
                                        value="Начать тестирование"
                                        className="mt-3 test-page-start-button"
                                    />
                                ) : (
                                    <span>
                                        Для того чтобы пройти тестирование{' '}
                                        <AuthRegister
                                            wrapped={<span className="legrand-text-btn">авторизуйтесь</span>}
                                        />{' '}
                                        в системе.
                                    </span>
                                )}
                            </div>
                        </div>
                    )}
                    {inProgress && (
                        <TestAndResultWrapper
                            test={data}
                            nextStep={nextStep}
                            currentPage={currentPage}
                            addUserAnswers={addUserAnswers}
                            publishRequest={publishRequest}
                            resultData={resultData}
                            finishTest={handleFinishTest}
                            publishError={publishError}
                        />
                    )}
                </div>
            </div>
        </div>
    );
};

const TestAndResultWrapper = ({
    currentPage,
    test,
    nextStep,
    addUserAnswers,
    publishRequest,
    resultData,
    finishTest,
    publishError,
}: any): React.ReactElement => {
    return test.questions.length > currentPage ? (
        <TestPage
            test={test}
            nextStep={nextStep}
            currentPage={currentPage}
            addUserAnswers={addUserAnswers}
            finishTest={finishTest}
        />
    ) : (
        <div className="test-page-wrapper">
            <div className="test-page-image-wrapper mt-3">
                {resultData && !!resultData.result.image && (
                    <img src={resultData.result.image} className="test-page-image" />
                )}
            </div>

            {publishRequest && (
                <div className="test-result-preloader-wrapper">
                    <Icon type="loading" className="test-result-preloader" />
                </div>
            )}
            {resultData && (
                <React.Fragment>
                    <div className="test-end-result mt-3">
                        <span className="test-end-result-correct">{resultData.points_result.points}</span>
                        {` / ${resultData.points_result.maxPoints}`}
                    </div>
                    <div className="test-end-text-title mt-3">{resultData.result.title}</div>
                    <div className="test-end-text-description mt-3">{resultData.result.description}</div>
                    <div className="test-page-end-button-wrapper mt-3">
                        <a href="/test" className="mt-3 legrand-btn btn-accent test-page-end-button">
                            Перейти к другим тестам
                        </a>
                    </div>
                </React.Fragment>
            )}

            {publishError && <div className="test-end-text-description mt-3">{publishError}</div>}

            {/*
            // TODO: Начисление баллов за прохождение теста
            <div className="test-bonus-points">
                Вам начислено{' '}
                <span className="test-bonus-points-accent">
                    {finishInfo.bonusPoints}{' '}
                    {num2str(finishInfo.bonusPoints, ['балл', 'былла', 'баллов'])}{' '}
                </span>
                по Программе лояльности
            </div>
            */}
        </div>
    );
};

export default Test;
