import * as React from "react";
import { Button } from "antd";

interface IAddItem {
    action: () => void;
    icon?: React.ReactNode;
    text: string;
}

const AddItem = ({ action, icon = null, text }: IAddItem) => {
    return (
        <div className="add-item-btn-wrapper">
            <Button type="link" onClick={action}>
                {icon}
                {text}
            </Button>
        </div>
    );
};

export default AddItem;
