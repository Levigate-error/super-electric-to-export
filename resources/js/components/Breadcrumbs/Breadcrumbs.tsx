import * as React from "react";
import classnames from "classnames";

interface IBreadcrumbs {
    breadcrumbs?: TBreadcrumb[];
}

type TBreadcrumb = {
    title: string;
    url?: string;
};

const Breadcrumbs = ({ breadcrumbs = [] }: IBreadcrumbs) => {
    return (
        breadcrumbs.length > 0 && (
            <section id="breadcrumbs">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-12">
                            <ul className="breadcrumb">
                                <li>
                                    <a href="/">Главная</a>
                                </li>
                                {breadcrumbs.map(el => (
                                    <li
                                        className={classnames(
                                            "breadcrumbs-item",
                                            { active: !el.url }
                                        )}
                                        key={el.title}
                                    >
                                        {el.url ? (
                                            <a href={el.url}>{el.title}</a>
                                        ) : (
                                            el.title
                                        )}
                                    </li>
                                ))}
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        )
    );
};

export default Breadcrumbs;
