//
//  ViewController.h
//  FlashApp
//
//  Created by Monte's Pro 13" on 9/19/15.
//  Copyright © 2015 Monte Thakkar. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "HomeModel.h"

@interface ViewController : UIViewController <UITableViewDataSource, UITableViewDelegate, HomeModelProtocol>

@property (weak, nonatomic) IBOutlet UITableView *listTableView;

@end

