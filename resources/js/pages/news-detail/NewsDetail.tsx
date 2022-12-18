/* eslint-disable @typescript-eslint/camelcase */
import * as React from 'react';
import PageLayout from '../../components/PageLayout';
import * as moment from 'moment';
import OtherNews from './components/OtherNews/OtherNews';
import { TNews } from './types';
import { getNews } from './api';
import { Icon } from 'antd';
interface INewsDetail {
    store: any;
}

interface IState {
    otherNews: TNews[];
    isLoading: boolean;
}

export class NewsDetail extends React.Component<INewsDetail, IState> {
    state = {
        otherNews: [],
        isLoading: false,
    };

    handleGetNews = () => {
        this.setState({ isLoading: true });

        getNews({})
            .then(response => {
                const {
                    data: { news },
                } = response;

                this.setState({ isLoading: false, otherNews: news });
            })
            .catch(err => {});
    };

    componentDidMount() {
        this.handleGetNews();
    }

    render() {
        const {
            store: {
                news: { id, title, description, image, created_at },
            },
        } = this.props;

        const { otherNews, isLoading } = this.state;

        return (
            <div className="container news-detail-wrapper">
                <div className="row mt-4">
                    <div className="col-12 col-md-8">
                        <h1 className="news-detail-title">{title}</h1>
                    </div>
                </div>
                <div className="row mt-3">
                    <div className="col-12  col-md-8 news-detail-date">{moment(created_at).format('DD.MM.YYYY')}</div>
                </div>
                {!!image && (
                    <div className="row">
                        <div className="col-12  col-md-8">
                            <img src={image} className="news-detail-image" alt={title} />
                        </div>
                    </div>
                )}
                <div className="row mt-3">
                    <div
                        className="col-12  col-md-8 news-detail-content"
                        dangerouslySetInnerHTML={{ __html: description }}
                    ></div>
                </div>

                <div className="row mt-3">
                    <div className="col-12  news-detail-back-to-news-wrapper">
                        <a href="/news" className="legrand-text-btn">
                            &#8592; Вернуться к списку новостей
                        </a>
                    </div>
                </div>
                {!isLoading && !!otherNews.length && (
                    <div className="row">
                        <div className="col-12">
                            <h3 className="other-news-title">Другие новости</h3>
                        </div>
                    </div>
                )}

                {isLoading ? (
                    <Icon type="loading" className="other-news-preloader" />
                ) : (
                    <OtherNews otherNews={otherNews} currentId={id} />
                )}
            </div>
        );
    }
}

export default PageLayout(NewsDetail);
