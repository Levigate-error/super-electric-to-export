import * as React from 'react';

const Rules = ({ loggedIn, onRegister }) => {
  return (
    <div className="rules" id={"rules"}>
      <div className="rules_container">
        <div className="rules_title">Правила акции</div>
        <div className="rules_subtitle">Сроки проведения с 1 июля по 30 ноября  2022 года</div>
        <div className="rules_box">
          <div className="rules_item">
            <img className="rules_img" alt="#" src="/img/rules-icon-1.png" />
            <div className="rules_text">
              Приобретайте продукцию Legrand и BTicino в авторизированных магазинах партнеров на сумму от 5000₽ и получайте на кассе купоны
            </div>
          </div>
          <div className="rules_item">
            <img className="rules_img" alt="#" src="/img/rules-icon-2.png" />
            <div className="rules_text">Регистрируйте полученные промокоды в личном кабинете</div>
            {loggedIn ? (
              <a href="/leto_legrand" className="rules_btn">Зарегистрировать промокод</a>
            ) : (
              <a onClick={onRegister} className="rules_btn">Зарегистрировать промокод</a>
            )}
          </div>
          <div className="rules_item">
            <img className="rules_img" alt="#" src="/img/rules-icon-3.png" />
            <div className="rules_text">Копите баллы и обменивайте их на ценные призы в личном кабинете</div>
            <a href="/Правила_программа_для_электриков_для_сайта_от_07.10.pdf" target="_blank" className="rules_btn">Полные правила</a>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Rules;
