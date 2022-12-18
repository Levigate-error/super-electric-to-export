import * as React from 'react';
import Accordion from './components/Accordion';

const Questions = () => (
  <div className="questions" id={"question"}>
    <div className="questions_container">
      <div className="questions_title">
        Вопросы - ответы
      </div>
      <div className="questions_box">
        <Accordion title="КАК ПОЛУЧИТЬ ПРОМОКОД?" text="Промокод вручается за покупку продукции «Legrand» на сумму кратную 5000 рублей в магазинах партнеров, участвующих в акции." />
        <Accordion title="КАКИЕ МАГАЗИНЫ УЧАСТВУЮТ В АКЦИИ?" text="В акции участвуют подтвержденные партнёры компании Legrand. Следите за списком магазинов на портале <a target='_blank' href='https://superelektrik.ru/'>https://superelektrik.ru/</a>. Количество магазинов будет увеличиваться." />
        <Accordion title="КАК ЗАРЕГИСТРИРОВАТЬ ПРОМОКОД? " text="Промокод, полученный от продавца, необходимо зарегистрировать в личном кабинете на портале <a target='_blank' href='https://superelektrik.ru/'>https://superelektrik.ru/</a>. Также, отдельно необходимо загрузить на проверку чек, за который был получен конкретный промокод." />
        <Accordion title="КАК НАКОПИТЬ БАЛЛЫ?" text="За каждый зарегистрированный и прошедший проверку промокод – Вы получите 100 баллов, которые можно будет обменять на призы." />
        <Accordion title="КАК ПОЛУЧАТЬ ПРИЗЫ?" text="В вашем личном кабинете отображается количество баллов и доступные для заказа призы. По достижению нужного количества баллов, у вас появится возможность заказать понравившийся вам приз, обменяв его на баллы." />
        <Accordion title="КАК СТАТЬ ПОБЕДИТЕЛЕМ ГЛАВНЫХ ПРИЗОВ?" text="Обладателями главных призов станут 3 участника, которые загрузят наибольшее количество промокодов, прошедших проверку с чеком." />
        <Accordion title="У МЕНЯ ОСТАЛИСЬ ВОПРОСЫ, КУДА Я МОГУ ОБРАТИТЬСЯ?" text="Если, среди данных вопросов, вы не нашли ответ на интересующий вас вопрос, то можете обратиться на почту обратной связи <a target='_blank' href='mail:info@legrand-promo.ru'>info@legrand-promo.ru</a>" />
      </div>
      <img className="questions_img" alt="#" src="/img/questions-img.png" />
    </div>
  </div>
);

export default Questions;
