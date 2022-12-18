import styled from 'styled-components';

const Wrapper = styled.div`
  padding: 208px 0 225px;
  position: relative;

  &:after {
      z-index: -2;
      content: '';
      display: block;
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: #9BCAEE;
  }

  @media (max-width: 1024px) {
    padding: 50px 30px;
  }
  @media (max-width: 800px) {
    padding: 50px 10px;
  }
`;

const Container = styled.div`
  max-width: 1200px;
  margin: 0 auto;
  justify-content: space-between;
  display: flex;
  @media (max-width: 1024px) {
    flex-direction: column;
  }
`;
const Title = styled.div`
  font-family: 'Raleway';
  font-style: normal;
  font-weight: 400;
  font-size: 60px;
  line-height: 70px;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  font-feature-settings: 'pnum' on, 'lnum' on;
  color: #FFFFFF;
  padding-top: 80px;
  z-index: 2;
  @media (max-width: 1024px) {
    margin-bottom: 55px;
  }
  @media (max-width: 800px) {
    font-size: 30px;
    line-height: 40px;
  }
`;
const Box = styled.div``;
const Img = styled.img`
  position: absolute;
  right: 0px;
  top: 0px;
  max-width: 100%;
  height: 100%;
  z-index: -1;
  @media (max-width: 1024px) {
     display: none;
  }
`;
export default {
  Wrapper,
  Title,
  Img,
  Box,
  Container,
};
