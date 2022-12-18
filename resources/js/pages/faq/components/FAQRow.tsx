import * as React from 'react';
import classnames from 'classnames';
import { Icon } from 'antd';

interface IFAQRow {
    row: TFaq;
}

type TFaq = {
    id: number;
    question: string;
    answer: string;
    created_at: string;
};

const FAQRow = ({ row }: IFAQRow): React.ReactElement => {
    const [isOpen, setIsOpen] = React.useState(false);

    const handleToggleRow = () => setIsOpen(!isOpen);

    return (
        <div className="faq-row-wrapper">
            <div className="faq-row-head" onClick={handleToggleRow}>
                <div className="faq-row-title">
                    <div className="content" dangerouslySetInnerHTML={{ __html: row.question }}></div>
                </div>
                <Icon type={isOpen ? 'up' : 'down'} className="faq-row-icon" />
            </div>

            <div className={classnames('faq-row-description', { 'faq-row-description-hidden': !isOpen })}>
                <div className="content" dangerouslySetInnerHTML={{ __html: row.answer }}></div>
            </div>
        </div>
    );
};

export default FAQRow;
