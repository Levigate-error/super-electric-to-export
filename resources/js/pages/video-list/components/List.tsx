import * as React from 'react';
import VideoItem from './VideoItem';

interface IList {
    videos: TVideo[];
}

type TVideo = {
    id: number;
    title: string;
    video: string;
    created_at: string;
};

const List = ({ videos }: IList) => {
    return (
        <React.Fragment>
            {videos.length
                ? videos.map(item => <VideoItem item={item} key={item.id} />)
                : 'По Вашему запросу видео не найдены'}
        </React.Fragment>
    );
};

export default List;
