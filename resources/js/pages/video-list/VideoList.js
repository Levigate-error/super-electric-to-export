"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const PageLayout_1 = require("../../components/PageLayout");
const Input_1 = require("../../ui/Input");
const api_1 = require("./api");
const Spinner_1 = require("../../ui/Spinner");
const lodash_1 = require("lodash");
const List_1 = require("./components/List");
const spinerStyle = {
    position: 'relative',
    margin: '0 auto',
    paddingTop: '100px',
};
class VideoList extends React.Component {
    constructor() {
        super(...arguments);
        this.state = {
            selectedCategoryId: (this.props.store.videoCategories[0] && this.props.store.videoCategories[0].id) || false,
            searchValue: '',
            isLoading: false,
            videos: [],
        };
        this.handleGetVideoList = lodash_1.debounce(params => {
            this.setState({ isLoading: true });
            api_1.searchVideo(params)
                .then(response => {
                this.setState({ isLoading: false, videos: response.data.videos });
            })
                .catch(err => {
                this.setState({ isLoading: false, videos: [] });
            });
        }, 600);
        this.handleChangeSearchInput = e => {
            const val = e.target.value;
            this.setState({ searchValue: val }, () => {
                const { searchValue } = this.state;
                if (searchValue.length >= 3) {
                    this.handleGetVideoList({ search: val });
                }
                else if (searchValue === '') {
                    this.handleGetVideoList({});
                }
            });
        };
        this.handleSelectCategory = id => {
            this.setState({ selectedCategoryId: id }, () => this.handleGetVideoList({ video_category_id: id }));
        };
    }
    componentDidMount() {
        const { selectedCategoryId } = this.state;
        selectedCategoryId && this.handleGetVideoList({});
    }
    render() {
        const { store: { videoCategories }, } = this.props;
        const { searchValue, isLoading, videos } = this.state;
        return (React.createElement("div", { className: "container video-list-wrapper" },
            React.createElement("div", { className: "row mt-4" },
                React.createElement("div", { className: "col-12" },
                    React.createElement("h3", null, "\u0412\u0438\u0434\u0435\u043E"))),
            React.createElement("div", { className: "row" },
                React.createElement("div", { className: "col-12 col-md-3  mt-3 video-list-categories-wrapper" },
                    React.createElement(Input_1.default, { value: searchValue, isLoading: isLoading, onChange: this.handleChangeSearchInput, placeholder: "Поиск видео", icon: React.createElement("i", { className: "fa fa-search", "aria-hidden": "true" }) }),
                    React.createElement("br", null),
                    React.createElement("h3", { className: "video-list-categories-header" }, "\u041A\u0430\u0442\u0435\u0433\u043E\u0440\u0438\u0438"),
                    React.createElement("ul", { className: "video-list-categories" }, videoCategories.map(category => (React.createElement("li", { className: "video-list-category", key: category.id, onClick: () => this.handleSelectCategory(category.id) },
                        React.createElement("span", { className: "video-list-category-title" }, category.title)))))),
                React.createElement("div", { className: "col-12 col-md-9 row  mt-3 video-list-videos-wrapper" }, isLoading ? React.createElement(Spinner_1.default, { style: spinerStyle }) : React.createElement(List_1.default, { videos: videos })))));
    }
}
exports.VideoList = VideoList;
exports.default = PageLayout_1.default(VideoList);
