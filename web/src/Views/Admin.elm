module Views.Admin exposing (..)

import Html as H exposing (Html)
import Html.Attributes as A


type Msg
    = SetName String
    | SetPassword String
    | Submit


type alias Model =
    { name : String
    , password : String
    }


addOrganization =
    H.section [ A.class "add-org-form form-s" ]
        [ H.h2 [] [ H.text "Add watcher or notifier" ]
        , H.input [ A.type' "text", A.placeholder "Name" ] []
        , H.input [ A.type' "text", A.placeholder "identifier / CUI" ] []
        , H.input [ A.type' "email", A.placeholder "Email" ] []
        , H.div [ A.class "role" ]
            [ H.span [] [ H.text "Role:" ]
            , H.label []
                [ H.input [ A.type' "radio", A.name "role" ] []
                , H.text "Watcher"
                ]
            , H.label []
                [ H.input [ A.type' "radio", A.name "role" ] []
                , H.text "Notifier"
                ]
            ]
        , H.button [ A.class "submit" ] [ H.text "Submit" ]
        ]


showNotifiers () =
    H.section [ A.class "organizations-table" ]
        [ H.h2 [] [ H.text "Notifiers" ]
        , H.table []
            [ H.thead []
                [ H.tr []
                    [ H.th [] [ H.text "Organization Name" ]
                    , H.th [] [ H.text "Identifier" ]
                    , H.th [] [ H.text "Email" ]
                    , H.th [] [ H.text "Role" ]
                    , H.th [] [ H.text "Status" ]
                    ]
                ]
            , H.tbody []
                [ H.tr []
                    [ H.td [] [ H.text "dummy Name" ]
                    , H.td [] [ H.text "dummy identifier" ]
                    , H.td [] [ H.text "dummy email" ]
                    , H.td [] [ H.text "Watcher or Notifier" ]
                    , H.td [] [ H.text "Invited or Joined" ]
                    ]
                , H.tr []
                    [ H.td [] [ H.text "dummy Name" ]
                    , H.td [] [ H.text "dummy identifier" ]
                    , H.td [] [ H.text "dummy email" ]
                    , H.td [] [ H.text "Watcher or Notifier" ]
                    , H.td [] [ H.text "Invited or Joined" ]
                    ]
                ]
            ]
        ]


showWatchers () =
    H.section [ A.class "organizations-table" ]
        [ H.h2 [] [ H.text "Watchers" ]
        , H.table []
            [ H.thead []
                [ H.tr []
                    [ H.th [] [ H.text "Organization Name" ]
                    , H.th [] [ H.text "Identifier" ]
                    , H.th [] [ H.text "Email" ]
                    , H.th [] [ H.text "Role" ]
                    , H.th [] [ H.text "Status" ]
                    ]
                ]
            , H.tbody []
                [ H.tr []
                    [ H.td [] [ H.text "dummy Name" ]
                    , H.td [] [ H.text "dummy identifier" ]
                    , H.td [] [ H.text "dummy email" ]
                    , H.td [] [ H.text "Watcher or Notifier" ]
                    , H.td [] [ H.text "Invited or Joined" ]
                    ]
                , H.tr []
                    [ H.td [] [ H.text "dummy Name" ]
                    , H.td [] [ H.text "dummy identifier" ]
                    , H.td [] [ H.text "dummy email" ]
                    , H.td [] [ H.text "Watcher or Notifier" ]
                    , H.td [] [ H.text "Invited or Joined" ]
                    ]
                ]
            ]
        ]
