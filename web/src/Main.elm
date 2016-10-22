module Main exposing (..)

import Html exposing (Html, section, div, text)
import Html.App
import Html.Attributes as A
import Views.Auth as Auth
import Views.Playground as Playground
import Auth.LoginForm as LoginForm exposing (Role(Admin))
import Routing
import Navigation


type alias Model =
    { loginInfo : LoginForm.State
    , route : Routing.Route
    }


type Msg
    = LoginMsg LoginForm.Msg


apiUrl : String
apiUrl =
    "http://77.81.165.2:8081/api/app.php"


loginUrl : String
loginUrl =
    apiUrl ++ "/authorize/login"


main : Program Never
main =
    Navigation.program Routing.parser
        { init = init
        , view = view
        , update = update
        , urlUpdate = urlUpdate
        , subscriptions = \_ -> Sub.none
        }


init : Result String Routing.Route -> ( Model, Cmd Msg )
init result =
    let
        currentRoute =
            Routing.routeFromResult result
    in
        ( initialModel currentRoute, Cmd.none )


initialModel : Routing.Route -> Model
initialModel route =
    { loginInfo = LoginForm.init
    , route = route
    }


urlUpdate : Result String Routing.Route -> Model -> ( Model, Cmd Msg )
urlUpdate result model =
    let
        currentRoute =
            Routing.routeFromResult result
    in
        ( { model | route = currentRoute }, Cmd.none )


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
view ({ route, loginInfo } as model) =
    case route of
        Routing.Login ->
            loginView model

        Routing.Playground ->
            Playground.view

        Routing.Home ->
            case loginInfo.role of
                Just (LoginForm.Admin) ->
                    adminView model

                Just (LoginForm.Watcher) ->
                    watcherView model

                Just (LoginForm.Notifier) ->
                    notifierView model

                Nothing ->
                    unauthorized


adminView : Model -> Html Msg
adminView model =
    text "Admin page"


watcherView : Model -> Html Msg
watcherView model =
    text "Watcher page"


notifierView : Model -> Html Msg
notifierView model =
    text "Notifier page"


loginView : Model -> Html Msg
loginView { loginInfo } =
    let
        loginView =
            Auth.loginForm loginUrl loginInfo
    in
        section [ A.class "main" ]
            [ Html.App.map LoginMsg loginView
            ]


unauthorized : Html Msg
unauthorized =
    text "You do not have access to this page"
