import React from "react";
import Profile from "./Profile";
import ReactDOMServer from "react-dom/server";

let { data } = context;
const html = ReactDOMServer.renderToString(<Profile store={data} />);
dispatch(html);
