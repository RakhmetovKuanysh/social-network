function test()
    nClock = os.clock()

    box.space.subscribers.index.subscriber_id:select({1})

    print(os.clock()-nClock)
end