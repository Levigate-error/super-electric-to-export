import styled from 'styled-components';

const Wrapper = styled.div`
  padding: 103px 0 103px;
  @media (max-width: 1024px) {
    padding: 50px 30px;
  }
`;
const Container = styled.div`
  max-width: 1440px;
  margin: 0 auto;
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
  color: #475054;
  @media (max-width: 800px) {
    font-size: 30px;
    line-height: 40px;
  }
`;
const Text = styled.div`
  font-family: 'Raleway';
  font-style: normal;
  font-weight: 400;
  font-size: 30px;
  line-height: 35px;
  color: #475175;
  margin: 30px 0 75px;
  max-width: 760px;
  &:last-of-type {
    margin: 76px auto 0;
    max-width: max-content;
  }
  @media (max-width: 800px) {
    font-size: 22px;
    line-height: 25px;
    margin-top: 15px;
  }
`;
const Img = styled.img`
  width: 100%;
  height: 100%;
`;

export default {
  Wrapper,
  Title,
  Container,
  Text,
  Img,
};
