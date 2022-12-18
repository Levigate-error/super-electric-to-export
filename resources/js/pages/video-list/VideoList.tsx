import * as React from 'react';
import PageLayout from '../../components/PageLayout';
import Input from '../../ui/Input';
import { searchVideo } from './api';
import Spiner from '../../ui/Spinner';
import debounce from '../../utils/debounce.js'
import List from './components/List';

interface IVideoList {
    store: any;
}

interface IState {
    selectedCategoryId: TCategory | false;
    searchValue: string;
    isLoading: boolean;
    videos: any[];
}

type TCategory = {
    id: number;
    title: string;
    created_at: string;
};

const spinerStyle = {
    position: 'relative',
    margin: '0 auto',
    paddingTop: '100px',
};

export class VideoList extends React.Component<IVideoList, IState> {
    state = {
        selectedCategoryId: (this.props.store.videoCategories[0] && this.props.store.videoCategories[0].id) || false,
        searchValue: '',
        isLoading: false,
        videos: [],
    };

    handleGetVideoList = debounce(params => {
        this.setState({ isLoading: true });
        searchVideo(params)
            .then(response => {
                this.setState({ isLoading: false, videos: response.data.videos });
            })
            .catch(err => {
                this.setState({ isLoading: false, videos: [] });
            });
    }, 600);

    handleChangeSearchInput = e => {
        const val = e.target.value;
        this.setState({ searchValue: val }, () => {
            const { searchValue } = this.state;
            if (searchValue.length >= 3) {
                this.handleGetVideoList({ search: val });
            } else if (searchValue === '') {
                this.handleGetVideoList({});
            }
        });
    };

    handleSelectCategory = id => {
        this.setState({ selectedCategoryId: id }, () => this.handleGetVideoList({ video_category_id: id }));
    };

    componentDidMount() {
        const { selectedCategoryId } = this.state;
        selectedCategoryId && this.handleGetVideoList({});
    }

    render() {
        const {
            store: { videoCategories },
        } = this.props;
        const { searchValue, isLoading, videos } = this.state;

        return (
            <div className="container video-list-wrapper">
                <div className="row mt-4">
                    <div className="col-12">
                        <h3>Видео</h3>
                    </div>
                </div>
                <div className="row">
                    <div className="col-12 col-md-3  mt-3 video-list-categories-wrapper">
                        <Input
                            value={searchValue}
                            isLoading={isLoading}
                            onChange={this.handleChangeSearchInput}
                            placeholder="Поиск видео"
                            icon={<i className="fa fa-search" aria-hidden="true" />}
                        />
                        <br />
                        <h3 className="video-list-categories-header">Категории</h3>
                        <ul className="video-list-categories">
                            {videoCategories.map(category => (
                                <li
                                    className="video-list-category"
                                    key={category.id}
                                    onClick={() => this.handleSelectCategory(category.id)}
                                >
                                    <span className="video-list-category-title">{category.title}</span>
                                </li>
                            ))}
                        </ul>
                    </div>
                    <div className="col-12 col-md-9 row  mt-3 video-list-videos-wrapper">
                        {isLoading ? <Spiner style={spinerStyle} /> : <List videos={videos} />}
                    </div>
                </div>
            </div>
        );
    }
}

export default PageLayout(VideoList);
