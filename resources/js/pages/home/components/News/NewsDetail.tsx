/* eslint-disable @typescript-eslint/interface-name-prefix */
import * as React from 'react';
import * as moment from 'moment';

interface INewsDetail {
    news: TNews;
}

export type TNews = {
    id: number;
    title: string;
    short_description: string;
    description: string;
    image: string;
    created_at: string;
};

const NewsDetail = ({ news }: INewsDetail): React.ReactElement => {
    return news ? (
        <React.Fragment>
            <a href={`/news/${news.id}`} className="home-page-news-title">
                {news.title}
            </a>
            <div className="home-page-news-date">{moment(news.created_at).format('DD.MM.YYYY')}</div>
            <div className="home-page-short-description">{news.short_description}</div>
        </React.Fragment>
    ) : null;
};

export default NewsDetail;
