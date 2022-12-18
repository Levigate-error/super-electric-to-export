import * as React from 'react';
import { INews } from './types';
import { Icon } from 'antd';
import { getNews } from './api';
import { reducer, initialState, actionTypes } from './reducer';
import NewsDetail from './NewsDetail';
import classnames from 'classnames';

const News = ({}: INews): React.ReactElement => {
    const [{ currentNews, isLoading, news, error }, dispatch] = React.useReducer(reducer, initialState);

    const handleGetNews = (page: number): void => {
        dispatch({ type: actionTypes.FETCH_NEWS });
        getNews({ page })
            .then(response => {
                const {
                    data: { news },
                } = response;
                dispatch({ type: actionTypes.FETCH_NEWS_SUCCESS, payload: news });
            })
            .catch(err => {
                dispatch({ type: actionTypes.FETCH_NEWS_FAILURE });
            });
    };

    React.useEffect(() => {
        handleGetNews(1);
    }, []);

    const nextAvailable = news.length - 1 > currentNews;
    const prevAvailable = currentNews > 0;
    const newsAvailable = news.length > 0;

    const handleNext = () => {
        if (nextAvailable) {
            dispatch({ type: actionTypes.SET_CURRENT_NEWS, payload: currentNews + 1 });
        }
    };

    const handlePrev = () => {
        if (prevAvailable) {
            dispatch({ type: actionTypes.SET_CURRENT_NEWS, payload: currentNews - 1 });
        }
    };

    return (
        <div className="card home-page-card mb-3">
            {!isLoading && !error && newsAvailable && (
                <div className="home-page-news-btns-wrapper">
                    <Icon
                        type="left"
                        onClick={handlePrev}
                        className={classnames('home-page-news-btn', {
                            'home-page-news-btn-disabled': !prevAvailable,
                        })}
                    />
                    <Icon
                        type="right"
                        onClick={handleNext}
                        className={classnames('home-page-news-btn', {
                            'home-page-news-btn-disabled': !nextAvailable,
                        })}
                    />
                </div>
            )}
            <div className="news-wrapper">
                <div className="home-page-card-background news-bg" />

                <span className="home-page-card-news-title title">
                    <a href="/news" className="home-page-card-news-title-link">
                        Новости
                    </a>
                </span>

                {!isLoading && error && <div className="home-page-loading-news-error">Ошибка загрузки новостей</div>}

                {!isLoading && !newsAvailable && !error && (
                    <div className="home-page-news-not-found">Новости отсутствуют</div>
                )}

                {isLoading && !error ? (
                    <Icon type="loading" className="home-page-news-loading" />
                ) : (
                    newsAvailable && <NewsDetail news={news[currentNews]} />
                )}
            </div>
        </div>
    );
};

export default News;
