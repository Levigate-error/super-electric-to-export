import * as React from 'react';
import { TNews } from '../types';
import * as moment from 'moment';
import classnames from 'classnames';

interface INews {
    news: TNews;
    disabled?: boolean;
}

const News = ({ news, disabled = false }: INews): React.ReactElement => {
    const handleSelectNews = (id: number): void => {
        const baseUrl = window.location.origin;
        window.location.href = `${baseUrl}/news/${id}`;
    };

    const newsStyle = {
        backgroundImage: `url(${news.image})`
    };

    return (
        <div
            className={classnames('col-auto news-list-item-wrapper', {
                'news-list-item-disabled': disabled,
            })}
        >
            <div className="news-list-item" key={news.id} onClick={(): void => handleSelectNews(news.id)}>
                <div className="card news-list-card">
                    <div className="news-item-background" style={newsStyle}></div>
                    <span className="news-item-title">{news.title}</span>
                    <div className="news-item-date">{moment(news.created_at).format('DD.MM.YYYY')}</div>
                </div>
            </div>
        </div>
    );
};

export default News;
