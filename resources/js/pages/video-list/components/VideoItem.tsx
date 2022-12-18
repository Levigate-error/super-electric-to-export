import * as React from 'react';
import { videoIcon } from '../../../ui/Icons/Icons';
import Modal from '../../../ui/Modal/Modal';
import { getPreviewImage } from './helper';
import * as moment from 'moment';

interface IVideoItem {
    item: TVideo;
}

type TVideo = {
    id: number;
    title: string;
    created_at: string;
    video: string;
};

const VideoItem = ({ item }: IVideoItem) => {
    const [modalIsVisible, setModalVisibility] = React.useState(false);

    const handleOpenVideoModal = (): void => setModalVisibility(true);

    const handleCloseModal = (): void => setModalVisibility(false);

    const imgBackgroundStyle = {
        backgroundImage: React.useMemo(() => getPreviewImage(item.video), [item.video]),
    };

    return (
        <div className="col-auto mb-3">
            {modalIsVisible && (
                <Modal isOpen={modalIsVisible} onClose={handleCloseModal} hiddenHeader={true}>
                    <iframe
                        height={280}
                        className="video-list-item-frame"
                        src={item.video}
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                        allowFullScreen
                    ></iframe>
                </Modal>
            )}

            <div className="card video-list-item" onClick={handleOpenVideoModal}>
                <div className="video-list-item-img-wrapper">
                    {videoIcon}

                    <div className="video-list-item-img" style={imgBackgroundStyle}></div>
                </div>
                <div className="video-list-item-title" onClick={handleOpenVideoModal}>
                    {item.title}
                </div>
                <div className="video-list-item-date">{moment(item.created_at).format('DD.MM.YYYY')}</div>
            </div>
        </div>
    );
};

export default VideoItem;
