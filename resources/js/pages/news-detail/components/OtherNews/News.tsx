import * as React from 'react';
import * as moment from 'moment';
import { TNews } from '../../types';

interface INews {
    news: TNews;
}

const News = ({ news }: INews): React.ReactElement => {
    const handleSelectNews = (id: number): void => {
        const baseUrl = window.location.origin;
        window.location.href = `${baseUrl}/news/${id}`;
    };

    return (
        <div className="col-auto other-news-list-item-wrapper">
            <div className="other-news-list-item" key={news.id} onClick={(): void => handleSelectNews(news.id)}>
                <div className="card other-news-list-card">
                    <span className="other-news-item-title">{news.title}</span>
                    <div className="other-news-item-date">{moment(news.created_at).format('DD.MM.YYYY')}</div>
                </div>
            </div>
        </div>
    );
};

export default News;
