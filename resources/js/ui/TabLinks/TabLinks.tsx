import * as React from "react";
import classnames from "classnames";

interface ITabLinks {
    links: TLink[];
    id: number;
}

type TLink = {
    url: string;
    title: string;
    selected: boolean;
};
const TabLinks = ({ links, id }: ITabLinks) => {
    return (
        <div className="tab-links">
            <ul>
                {links.map((link: TLink) => (
                    <li
                        key={link.title}
                        className={classnames({
                            "tab-link-selected": link.selected
                        })}
                    >
                        <a href={`${link.url}/${id}`}>{link.title}</a>
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default TabLinks;
