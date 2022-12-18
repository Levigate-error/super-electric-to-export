import * as React from 'react';
import PageLayout from '../../components/PageLayout';
import News from './components/News';
import { TNews } from './types';
import Paginate from '../../ui/Paginate';
import { getNews } from './api';

interface INewsList {
    store: any;
}

interface IState {
    news: TNews[];
    currentPage: number;
    total: number;
    lastPage: number;
    isLoading: boolean;
}

export class NewsList extends React.Component<INewsList, IState> {
    state = {
        currentPage: this.props.store.news.currentPage,
        total: this.props.store.news.total,
        lastPage: this.props.store.news.lastPage,
        isLoading: false,
        news: this.props.store.news.news,
    };

    handleChangePage = ({ selected }): void => {
        const { currentPage } = this.state;
        const targetPage = selected + 1;

        if (currentPage !== targetPage) {
            this.handleGetNews(targetPage);
        }
    };

    handleGetNews = (page: number): void => {
        this.setState({ isLoading: true });
        getNews({ page })
            .then(response => {
                const {
                    data: { total, currentPage, news, lastPage },
                } = response;

                this.setState({ isLoading: false, total, currentPage, news, lastPage });
            })
            .catch(err => {});
    };

    render() {
        const { news, lastPage, currentPage, isLoading } = this.state;

        return (
            <div className="container news-list-wrapper">
                <div className="row mt-4">
                    <div className="col-12">
                        <h3>Новости</h3>
                    </div>
                </div>
                <div className="row mt-3">
                    {news.map((item: TNews) => (
                        <News news={item} disabled={isLoading} />
                    ))}
                </div>
                <div className="row mt-3">
                    <div className="col-12 news-list-paginate ">
                        <Paginate
                            initialPage={currentPage - 1}
                            pageCount={lastPage}
                            pageRangeDisplayed={2}
                            onPageChange={this.handleChangePage}
                            marginPagesDisplayed={2}
                            disabled={isLoading}
                        />
                    </div>
                </div>
            </div>
        );
    }
}

export default PageLayout(NewsList);
