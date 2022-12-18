import * as React from "react";
import Button from "../../../ui/Button";
import { applyChanges } from "../api";

interface IChange {
    change: any; // TODO: add types
    projectId;
}

const Change = ({ change, projectId }: IChange) => {
    const [isApply, setApply] = React.useState(false);

    const handleApply = () => {
        applyChanges(change.id, projectId)
            .then(response => {
                setApply(true);
            })
            .catch(err => {});
    };

    return (
        <li className="project-changes-item">
            <span className="project-change-type">
                Изменение: {change.typeOnHuman}
            </span>
            <span className="project-change-vendor">
                Артикул: {change.vendor_code}
            </span>
            <span className="project-change-name">Название: {change.name}</span>
            {change.old_value && (
                <span className="project-change-old-value">
                    Старое значение:
                    {change.old_value}
                </span>
            )}
            {change.new_value && (
                <span className="project-change-new-value">
                    Новое значение:
                    {change.new_value}
                </span>
            )}
            <Button
                value={isApply ? "сохранено" : "Применить"}
                onClick={handleApply}
                appearance={isApply ? "second" : "accent"}
                small
                className="project-changes-apply-btn"
                disabled={isApply}
            />
        </li>
    );
};

export default Change;
