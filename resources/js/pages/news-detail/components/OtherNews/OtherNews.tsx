import * as React from 'react';
import News from './News';
import { TNews } from '../../types';

interface IOtherNews {
    otherNews?: TNews[];
    currentId: number;
}

const OtherNews = ({ otherNews, currentId }: IOtherNews): React.ReactElement => {
    const prepareNews = (): TNews[] => {
        let arr = [];
        let counter = 0;
        for (let i = 0; otherNews.length > i; i++) {
            if (otherNews[i] && otherNews[i].id !== currentId && counter < 3) {
                counter++;
                arr = [...arr, <News news={otherNews[i]} key={otherNews[i].id} />];
            }
        }

        return arr;
    };

    return <div className="row">{prepareNews()}</div>;
};

export default OtherNews;
