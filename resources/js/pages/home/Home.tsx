import * as React from 'react';
import { IHome } from './types';
import News from './components/News';
import Projects from './components/Projects';
import PageLayout from '../../components/PageLayout';
import { createProject } from './api';
import AnalogSelect from '../../components/SelectionAnalog';
import Banner from './components/Banner';
// import PopUp from "../../ui/PopUp";

interface IState {
    analogVisibility: boolean;
    createRequest: boolean;
  popUplIsOpen: boolean;
}

class Home extends React.Component<IHome, IState> {
    state = {
        analogVisibility: false,
        createRequest: false,
        popUplIsOpen: true,
    };

    handleCreateProject = () => {
      // @ts-ignore
        this.setState({ createRequest: true });
        const base_url = window.location.origin;
        createProject()
            .then(response => {
                document.location.href = base_url + '/project/update/' + response.data.id;
            })
            .catch(() => {
              // @ts-ignore
                this.setState({ createRequest: false });
            });
    };


  // @ts-ignore
    handleOpenAnalogSelect = () => this.setState({ analogVisibility: true });
  // @ts-ignore
    handleCloseAnalogSelect = () => this.setState({ analogVisibility: false });

    handleClosePopUp = () => this.setState({ popUplIsOpen: false });

    render() {
        const {
            store: {
                projects: { projects },
                userResource,
            },
        } = this.props;
        const { analogVisibility,
            createRequest,
            // popUplIsOpen
        } = this.state;

        return (
            <div className="container mt-3 home-page-wrapper" key="container">
                {analogVisibility && (
                    <AnalogSelect
                        onClose={this.handleCloseAnalogSelect}
                        isOpen={analogVisibility}
                        user={userResource}
                    />
                )}



                <div className="row ">
                    <div className="col-12">
                        <Banner />
                    </div>
                </div>

              {/*<PopUp isOpen={popUplIsOpen} onClose={this.handleClosePopUp}>*/}
              {/*  <div className="loyalty__pop-up-container">*/}
              {/*    <h1 className="mb-3 loyalty-modal__title loyalty__pop-up-title">?????????? ???????? ?? LEGRAND ???????????????? ???? 30.11.2022</h1>*/}
              {/*    <p className="loyalty__pop-up-text">???????????????? ?????????????????????? ?????????????????????? ??????????????????!*/}
              {/*      ???????????? ?? ?????????? ?????????????????? ?????????????????? ???????????? BTicino. ???????? ???? ?????? ???? ???????????? ???????????????? ???????????? ??????????, ???? ???????? ???????? ?????? ??????!</p>*/}
              {/*  </div>*/}
              {/*</PopUp>*/}

              {/*<div className="b-marquee b-marquee--rtl">*/}
              {/*  <div className="b-marquee__text">?????????? ???????? ?? LEGRAND ???????????????? ???? 30.11.2022 ?? ???????????????? ?????????????????????? ?????????????????????? ??????????????????</div>*/}
              {/*</div>*/}

                <div className="row mt-3">
                    {/*<div className="col-md-4">*/}
                        {/*<a href="loyalty-program" className="card home-page-card mb-3">*/}
                            {/*<div className="home-page-card-background loyalty-program" />*/}
                            {/*<span className="title">?????????????????? ????????????????????</span>*/}
                        {/*</a>*/}
                    {/*</div>*/}
                    {/*<div className="col-md-4">*/}
                        {/*<a href="promo" className="card home-page-card mb-3">*/}
                            {/*<div className="home-page-card-background inspiria" />*/}
                        {/*</a>*/}
                    {/*</div>*/}
                    <div className="col-md-8">
                      <div className="card home-page-card mb-3 home-page-legrand">
                        <div className="home-page-legrand__content">
                          <div className="home-page-legrand__content-text home-page-legrand__content-text--large">??????????<br />
                              ?????????? ?? LEGRAND??<br />??????????????????!</div>
                          <div className="home-page-legrand__content-text home-page-legrand__content-text--medium ">???????????????????? ?????? ???? ???????????????? ??????????????</div>
                          <div className="home-page-legrand__content-text home-page-legrand__content-text--small ">
                              ?????????????? ???? ?????????????????? ?? ????????????????<br />
                              ?? ?????????????? ????????????
                          </div>
                        </div>
                      </div>
                    </div>
                    <div className="col-md-4">
                        <a href="https://configurator.legrand.ru/configurator/" className="card home-page-card mb-3">
                            <div className="home-page-card-background configurator" />
                        </a>
                    </div>
                    <div className="col-md-4">
                      <News />
                    </div>
                    <div className="col-md-4">
                        <Projects
                            createProjetc={this.handleCreateProject}
                            projects={projects}
                            createRequest={createRequest}
                        />
                    </div>
                    <div className="col-md-4">
                        <div className="card home-page-card mb-3" onClick={this.handleOpenAnalogSelect}>
                            <div className="home-page-card-background analog-selection" />
                            <span className="title">???????????? ???????????????????? ???????????????????????? Legrand ???? ????????????????</span>
                        </div>
                    </div>
                </div>
                <div className="row ">
                    <div className="col-md-4">
                        <a href={`catalog?category_id=2`} className="card home-page-card mb-3">
                            <div className="home-page-card-background modular-equipment" />
                            <span className="title">?????????????????? ????????????????????????</span>
                        </a>
                    </div>

                    <div className="col-md-4">
                        <a href={`catalog?category_id=1`} className="card home-page-card mb-3">
                            <div className="home-page-card-background  wiring-equipment" />
                            <span className="title">?????????????????????????????????????? ????????????????????????</span>
                        </a>
                    </div>

                    <div className="col-md-4">
                        <a
                            href="https://legrand.ru/services/learning"
                            target="_blank"
                            className="card home-page-card mb-3"
                        >
                            <div className="home-page-card-background training" />
                            <span className="title">????????????????</span>
                        </a>
                    </div>
                </div>
            </div>
        );
    }
}

export default PageLayout(Home);
