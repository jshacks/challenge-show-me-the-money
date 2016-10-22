module Main exposing (..)

import Html exposing (Html, section, div, text)
import Html.App
import Html.Attributes as A
import Views.Auth as Auth
import Auth.LoginForm as LoginForm


type alias Model =
    { loginInfo : LoginForm.State
    }


type Msg
    = LoginMsg LoginForm.Msg


apiUrl : String
apiUrl =
    "http://77.81.165.2:8081/api/app_dev.php"


loginUrl : String
loginUrl =
    apiUrl ++ "/authorize/login"


main : Program Never
main =
    Html.App.program
        { init = init ! []
        , view = view
        , update = update
        , subscriptions = \_ -> Sub.none
        }


init : Model
init =
    { loginInfo = LoginForm.init
    }


update : Msg -> Model -> ( Model, Cmd Msg )
update msg model =
    case msg of
        LoginMsg loginMsg ->
            let
                ( loginInfo, loginCmd ) =
                    LoginForm.update loginMsg model.loginInfo
            in
                { model | loginInfo = loginInfo } ! [ Cmd.map LoginMsg loginCmd ]


view : Model -> Html Msg
view { loginInfo } =
    let
        loginView =
            Auth.loginForm loginUrl loginInfo
    in
        section [ A.class "main" ]
            [ Html.App.map LoginMsg loginView
            ]
