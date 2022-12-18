import * as React from 'react';

const Production = ({ addressesPdfLink }) => (
  <div className="production">
    <div className="production_box">
      <div className="production_text production_text--big">ПРИОБРЕтай ПРОДУКЦИЮ
        LEGRAND и BTICINO</div>
      <div className="production_text">у официальных партнеров, участвующих в акции</div>
      <a target="_blank" href={addressesPdfLink} className="production_btn">Полный список</a>
    </div>
    <div className="production_box">
      <img alt="#" src="/img/prod-img.png" className="production_img" />
    </div>
  </div>
);

export default Production;
