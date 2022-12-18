import * as React from 'react';
import { Tabs } from 'antd';
const { TabPane } = Tabs;

interface ITabs {
    tabs: TTab[];
    defaultKey?: string | number;
    onSelect?: (key: string) => void;
}

type TTab = {
    key: string;
    title: string;
    child: any;
};

const TabsComponent = ({ tabs = [], onSelect, defaultKey = 1 }: ITabs) => {
    return (
        <Tabs defaultActiveKey={`${defaultKey}`} onChange={onSelect}>
            {tabs.map(tab => (
                <TabPane tab={tab.title} key={tab.key}>
                    {tab.child}
                </TabPane>
            ))}
        </Tabs>
    );
};

export default TabsComponent;
